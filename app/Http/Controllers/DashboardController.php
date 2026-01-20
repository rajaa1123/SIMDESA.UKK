<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\Permohonan;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Data Keuangan (Hanya untuk Admin & Kades)
        $saldo = 0;
        if ($user->isAdmin() || $user->isKepalaDesa()) {
            $totalMasuk = \App\Models\Keuangan::where('tipe', 'masuk')->sum('jumlah');
            $totalKeluar = \App\Models\Keuangan::where('tipe', 'keluar')->sum('jumlah');
            $saldo = $totalMasuk - $totalKeluar;
        }

        if ($user->isWarga()) {
            // Untuk warga: hanya tampilkan pengajuan sendiri dengan status baru
            $stats = [
                'total_permohonan' => Permohonan::where('user_id', $user->id)->count(),
                'permohonan_pending' => Permohonan::where('user_id', $user->id)
                    ->whereHas('status', function($q) {
                        $q->where('code', 'pending')->where('group_key', 'pengajuan');
                    })->count(),
                'permohonan_diproses' => Permohonan::where('user_id', $user->id)
                    ->whereHas('status', function($q) {
                        $q->where('code', 'menunggu_persetujuan_kades')->where('group_key', 'pengajuan');
                    })->count(),
                'permohonan_selesai' => Permohonan::where('user_id', $user->id)
                    ->whereHas('status', function($q) {
                        $q->where('code', 'selesai')->where('group_key', 'pengajuan');
                })->count(),
                'total_layanan' => Layanan::count(),
            ];
            
            $recent_permohonan = Permohonan::with(['user', 'layanan', 'status'])
                ->where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get();
            
            // Status breakdown untuk chart
            $statusBreakdown = [
                'pending' => $stats['permohonan_pending'],
                'diproses' => $stats['permohonan_diproses'],
                'selesai' => $stats['permohonan_selesai'],
            ];
            
            // Layanan paling populer (top 5)
            $popularLayanan = Layanan::withCount('permohonan')
                ->orderBy('permohonan_count', 'desc')
                ->take(5)
                ->get();
            
            // Recent updates (permohonan yang statusnya berubah dalam 7 hari terakhir)
            $recentUpdates = Permohonan::with(['layanan', 'status'])
                ->where('user_id', $user->id)
                ->where('updated_at', '>=', now()->subDays(7))
                ->where('updated_at', '!=', DB::raw('created_at'))
                ->latest('updated_at')
                ->take(3)
                ->get();
            
            // Permohonan dengan hasil surat tersedia
            $permohonanWithSurat = Permohonan::with(['layanan'])
                ->where('user_id', $user->id)
                ->whereNotNull('hasil_surat_file')
                ->latest('hasil_surat_uploaded_at')
                ->take(5)
                ->get();
            
            // Berita terbaru untuk warga
            $latestBerita = \App\Models\Berita::whereNotNull('published_at')
                ->latest()
                ->take(3)
                ->get();
            
            return view('dashboard.index', compact('stats', 'recent_permohonan', 'statusBreakdown', 'popularLayanan', 'recentUpdates', 'permohonanWithSurat', 'latestBerita'));
                
        } elseif ($user->isAdmin()) {
            // Untuk admin: fokus pada pengajuan yang perlu verifikasi
            $stats = [
                'total_warga' => Warga::count(),
                'total_permohonan' => Permohonan::count(),
                'perlu_verifikasi' => Permohonan::whereHas('status', function($q) {
                    $q->where('code', 'pending')->where('group_key', 'pengajuan');
                })->count(),
                'saldo_keuangan' => $saldo,
                'total_layanan' => Layanan::count(),
            ];

            $recent_permohonan = Permohonan::with(['user', 'layanan', 'status'])
                ->latest()
                ->take(5)
                ->get();
            
            $statusBreakdown = [
                'pending' => Permohonan::whereHas('status', function($q) { $q->where('code', 'pending'); })->count(),
                'proses' => Permohonan::whereHas('status', function($q) { $q->where('code', 'menunggu_persetujuan_kades'); })->count(),
                'selesai' => Permohonan::whereHas('status', function($q) { $q->where('code', 'selesai'); })->count(),
            ];
            $popularLayanan = Layanan::withCount('permohonan')
                ->orderBy('permohonan_count', 'desc')
                ->take(5)
                ->get();
            $recentUpdates = collect();
            
            return view('dashboard.index', compact('stats', 'recent_permohonan', 'statusBreakdown', 'popularLayanan', 'recentUpdates'));
            
        } elseif ($user->isKepalaDesa()) {
            // Untuk Kades: fokus pada ringkasan desa dan approval akhir
            $stats = [
                'total_warga' => Warga::count(),
                'total_permohonan' => Permohonan::count(),
                'menunggu_approval' => Permohonan::whereHas('status', function($q) {
                    $q->where('code', 'menunggu_persetujuan_kades')->where('group_key', 'pengajuan');
                })->count(),
                'saldo_keuangan' => $saldo,
                'total_layanan' => Layanan::count(),
            ];

            $recent_permohonan = Permohonan::with(['user', 'layanan', 'status'])
                ->latest()
                ->take(5)
                ->get();

            $statusBreakdown = [
                'pending' => Permohonan::whereHas('status', function($q) { $q->where('code', 'pending'); })->count(),
                'proses' => $stats['menunggu_approval'],
                'selesai' => Permohonan::whereHas('status', function($q) { $q->where('code', 'selesai'); })->count(),
            ];
            
            $popularLayanan = Layanan::withCount('permohonan')
                ->orderBy('permohonan_count', 'desc')
                ->take(5)
                ->get();

            // Data Analitik (Tren 6 Bulan Terakhir)
            $labels = [];
            $permohonanTrend = [];
            $keuanganTrend = [];
            
            for ($i = 5; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $labels[] = $month->translatedFormat('F');
                
                $permohonanTrend[] = Permohonan::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count();
                
                $income = \App\Models\Keuangan::where('tipe', 'masuk')
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->sum('jumlah');
                $expense = \App\Models\Keuangan::where('tipe', 'keluar')
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->sum('jumlah');
                $keuanganTrend[] = $income - $expense;
            }

            $chartData = [
                'labels' => $labels,
                'permohonan' => $permohonanTrend,
                'keuangan' => $keuanganTrend
            ];

            return view('dashboard.index', compact('stats', 'recent_permohonan', 'statusBreakdown', 'popularLayanan', 'chartData'));
        }
    }

    /**
     * Tampilan landing page dengan statistik dinamis
     */
    public function landing()
    {
        $stats = [
            'total_layanan' => Layanan::count() ?: 20, // Fallback ke 20 jika kosong
            'total_warga' => Warga::count() ?: 1000,
            'total_permohonan' => Permohonan::count() ?: 500,
            'proses_cepat' => '100%'
        ];

        $latestBerita = \App\Models\Berita::whereNotNull('published_at')
            ->latest()
            ->take(3)
            ->get();

        return view('welcome', compact('stats', 'latestBerita'));
    }
}