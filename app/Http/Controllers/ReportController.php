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
                $q->where('code', 'pending');
            })->count(),
            'total_warga' => Warga::count(),
            'total_users' => User::count(),
            'permohonan_selesai' => Permohonan::whereHas('status', function($q) {
                $q->where('code', 'selesai');
            })->count(),
            'total_layanan' => Layanan::count(),
        ];
        
        return view('reports.index', compact('stats'));
    }

    public function permohonan(Request $request)
    {
        $query = Permohonan::with(['user', 'layanan', 'status']);
        
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
        
        // Statistics
        $stats = [
            'total' => Permohonan::count(),
            'pending' => Permohonan::whereHas('status', function($q) {
                $q->where('code', 'pending');
            })->count(),
            'diproses' => Permohonan::whereHas('status', function($q) {
                $q->where('code', 'diproses');
            })->count(),
            'selesai' => Permohonan::whereHas('status', function($q) {
                $q->where('code', 'selesai');
            })->count(),
            'ditolak' => Permohonan::whereHas('status', function($q) {
                $q->where('code', 'ditolak');
            })->count(),
        ];
        
        // Chart data - Permohonan per layanan
        $perLayanan = Permohonan::select('layanan_id', DB::raw('count(*) as total'))
            ->with('layanan')
            ->groupBy('layanan_id')
            ->get();
        
        $statuses = Status::where('group_key', 'permohonan')->get();
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
        // Hanya bisa diakses oleh kepala desa
        $query = Permohonan::with(['layanan', 'user'])
            ->where('biaya_admin', '>', 0);
            
        // Filter by date range
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('created_at', [
                $request->tanggal_mulai,
                $request->tanggal_selesai . ' 23:59:59'
            ]);
        }
            
        $financials = $query->latest()->paginate(20);
        
        // Total pendapatan
        $totalPendapatan = $query->sum('biaya_admin');
        
        // Pendapatan bulan ini
        $pendapatanBulanIni = Permohonan::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('biaya_admin');
            
        // Rata-rata per permohonan
        $rataRata = $query->count() > 0 ? $totalPendapatan / $query->count() : 0;
        
        // Pendapatan per bulan (6 bulan terakhir)
        $pendapatanPerBulan = Permohonan::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('YEAR(created_at) as tahun'),
                DB::raw('SUM(biaya_admin) as total')
            )
            ->where('biaya_admin', '>', 0)
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();
        
        $stats = [
            'total' => $totalPendapatan,
            'bulan_ini' => $pendapatanBulanIni,
            'rata_rata' => $rataRata,
        ];
        
        return view('reports.financial', compact('financials', 'stats', 'pendapatanPerBulan'));
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