<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Gallery;
use App\Models\Paket;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // --- Data untuk Info Box ---
        $userCount = User::where('role', '!=', 'admin')->count();
        $paketCount = Paket::count();
        $galleryCount = Gallery::count();
        $totalRevenue = Transaksi::whereIn('status', ['PAID', 'SUCCESS'])->sum('total_amount');

        // --- Data untuk Chart Pendapatan Bulanan (6 bulan terakhir) ---
        $salesData = Transaksi::select(
                DB::raw('SUM(total_amount) as total'),
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month")
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->whereIn('status', ['PAID', 'SUCCESS'])
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $salesLabels = $salesData->map(function ($item) {
            return Carbon::createFromFormat('Y-m', $item->month)->format('M Y');
        });
        $salesValues = $salesData->pluck('total');

        // --- Data untuk Daftar Pengguna Terbaru ---
        $latestMembers = User::where('role', '!=', 'admin')->latest()->take(8)->get();

        return view('dashboard', compact(
            'userCount',
            'paketCount',
            'galleryCount',
            'totalRevenue',
            'latestMembers',
            'salesLabels',
            'salesValues'
        ));
    }
}
