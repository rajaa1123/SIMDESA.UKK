<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Models\Warga;
use App\Models\Layanan;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Statistics untuk dashboard cards
        $stats = [
            'total_permohonan' => Permohonan::count(),
            'permohonan_pending' => Permohonan::whereHas('status', function($q) {
                $q->where('code', 'pending')->where('group_key', 'pengajuan');
            })->count(),
            'total_warga' => Warga::count(),
            'total_users' => User::count(),
            'permohonan_selesai' => Permohonan::whereHas('status', function($q) {
                $q->where('code', 'selesai')->where('group_key', 'pengajuan');
            })->count(),
            'total_layanan' => Layanan::count(),
        ];
        
        return view('reports.index', compact('stats'));
    }

    public function permohonan(Request $request)
    {
        $query = Permohonan::with(['user', 'layanan', 'status', 'adminUser', 'kadesUser']);
        
        // Filter by date range
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('created_at', [
                $request->tanggal_mulai,
                $request->tanggal_selesai . ' 23:59:59'
            ]);
        }
        
        // Filter by status
        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }
        
        // Filter by layanan
        if ($request->filled('layanan_id')) {
            $query->where('layanan_id', $request->layanan_id);
        }
        
        $permohonans = $query->latest()->paginate(20);
        
        // Statistics - using new pengajuan status
        $stats = [
            'total' => Permohonan::count(),
            'pending' => Permohonan::whereHas('status', function($q) {
                $q->where('code', 'pending')->where('group_key', 'pengajuan');
            })->count(),
            'menunggu_kades' => Permohonan::whereHas('status', function($q) {
                $q->where('code', 'menunggu_persetujuan_kades')->where('group_key', 'pengajuan');
            })->count(),
            'diproses' => Permohonan::whereHas('status', function($q) {
                $q->where('code', 'menunggu_persetujuan_kades')->where('group_key', 'pengajuan');
            })->count(),
            'selesai' => Permohonan::whereHas('status', function($q) {
                $q->where('code', 'selesai')->where('group_key', 'pengajuan');
            })->count(),
            'ditolak' => Permohonan::whereHas('status', function($q) {
                $q->where('code', 'ditolak')->where('group_key', 'pengajuan');
            })->count(),
        ];
        
        // Chart data - Permohonan per layanan
        $perLayanan = Permohonan::select('layanan_id', DB::raw('count(*) as total'))
            ->with('layanan')
            ->groupBy('layanan_id')
            ->get();
        
        // Get both old and new statuses for filter compatibility
        $statuses = Status::whereIn('group_key', ['permohonan', 'pengajuan'])->get();
        $layanans = Layanan::all();
        
        return view('reports.permohonan', compact('permohonans', 'stats', 'perLayanan', 'statuses', 'layanans'));
    }

    public function warga()
    {
        $wargas = Warga::with('kartuKeluarga')
            ->latest()
            ->paginate(20);
            
        $stats = [
            'total_warga' => Warga::count(),
            'total_kk' => \App\Models\KartuKeluarga::count(),
            'warga_laki' => Warga::where('jenis_kelamin', 'Laki-laki')->count(),
            'warga_perempuan' => Warga::where('jenis_kelamin', 'Perempuan')->count(),
        ];
        
        return view('reports.warga', compact('wargas', 'stats'));
    }

    public function financial(Request $request)
    {
        // Hanya bisa diakses oleh kepala desa / admin
        $query = \App\Models\Keuangan::with(['permohonan.layanan', 'user']);
            
        // Filter by date range
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal', [
                $request->tanggal_mulai,
                $request->tanggal_selesai
            ]);
        }

        // Filter by type (default to all or specific if filtered)
        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }
            
        $financials = $query->latest('tanggal')->latest('id')->paginate(20);
        
        // Stats calculations
        $totalMasuk = (clone $query)->where('tipe', 'masuk')->sum('jumlah');
        $totalKeluar = (clone $query)->where('tipe', 'keluar')->sum('jumlah');
        $saldo = $totalMasuk - $totalKeluar;
        
        // Monthly trend (6 months)
        $monthlyData = \App\Models\Keuangan::select(
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('YEAR(tanggal) as tahun'),
                DB::raw('SUM(CASE WHEN tipe = "masuk" THEN jumlah ELSE 0 END) as total_masuk'),
                DB::raw('SUM(CASE WHEN tipe = "keluar" THEN jumlah ELSE 0 END) as total_keluar')
            )
            ->where('tanggal', '>=', now()->subMonths(6))
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();
        
        $stats = [
            'total_masuk' => $totalMasuk,
            'total_keluar' => $totalKeluar,
            'saldo' => $saldo,
            'bulan_ini' => \App\Models\Keuangan::whereMonth('tanggal', now()->month)
                            ->whereYear('tanggal', now()->year)
                            ->where('tipe', 'masuk')
                            ->sum('jumlah'),
        ];
        
        $bulanNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'July', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        return view('reports.financial', compact('financials', 'stats', 'monthlyData', 'bulanNames'));
    }

    public function performance()
    {
        // Hanya bisa diakses oleh kepala desa
        $layanans = Layanan::withCount([
                'permohonan',
                'permohonan as selesai' => function($q) {
                    $q->whereHas('status', function($sq) {
                        $sq->where('code', 'selesai');
                    });
                }
            ])
            ->get();
            
        // Calculate metrics
        $layanans = $layanans->map(function($layanan) {
            $layanan->success_rate = $layanan->permohonan_count > 0 
                ? ($layanan->selesai / $layanan->permohonan_count) * 100 
                : 0;
            return $layanan;
        });
        
        $stats = [
            'total_layanan' => Layanan::count(),
            'total_permohonan' => Permohonan::count(),
            'avg_success_rate' => $layanans->avg('success_rate'),
        ];
            
        return view('reports.performance', compact('layanans', 'stats'));
    }
}