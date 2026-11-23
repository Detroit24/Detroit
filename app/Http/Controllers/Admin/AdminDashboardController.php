<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Template;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $thisMonthStart = $now->copy()->startOfMonth();
        $lastMonthStart = $thisMonthStart->copy()->subMonth();
        $lastMonthEnd = $thisMonthStart->copy()->subSecond();

        // 1. Total Pesanan (real data dari tabel orders)
        $totalOrders = Order::count();
        $thisMonthOrders = Order::whereBetween('created_at', [$thisMonthStart, $now])->count();
        $lastMonthOrders = Order::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
        $orderGrowth = $lastMonthOrders > 0 ? '+' . round((($thisMonthOrders - $lastMonthOrders) / $lastMonthOrders) * 100, 0) . '%' : '+0%';

        // 2. Pendapatan (real revenue dari order berstatus paid)
        $totalRevenue = (float) Order::where('status', 'paid')->sum('final_amount');
        $thisMonthRevenue = (float) Order::where('status', 'paid')->whereBetween('created_at', [$thisMonthStart, $now])->sum('final_amount');
        $lastMonthRevenue = (float) Order::where('status', 'paid')->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->sum('final_amount');
        $revenueGrowth = $lastMonthRevenue > 0 ? '+' . round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 0) . '%' : '+0%';

        // 3. Template Aktif
        $activeTemplates = Template::where('is_active', true)->count();
        $templatesThisMonth = Template::whereBetween('created_at', [$thisMonthStart, $now])->where('is_active', true)->count();
        $templatesLastMonth = Template::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->where('is_active', true)->count();
        $templateGrowth = $templatesLastMonth > 0 ? '+' . round((($templatesThisMonth - $templatesLastMonth) / $templatesLastMonth) * 100, 0) . '%' : '+0%';

        // 4. Monthly chart data (real revenue per bulan, 12 bulan terakhir)
        $months = [];
        $salesData = [];
        $chartStart = $thisMonthStart->copy()->subMonths(11);
        for ($i = 0; $i < 12; $i++) {
            $monthStart = $chartStart->copy();
            $monthEnd = $monthStart->copy()->addMonth()->subSecond();
            $revenue = (float) Order::where('status', 'paid')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('final_amount');

            $months[] = $monthStart->format('M');
            $salesData[] = (int) round($revenue / 1000000);
            $chartStart->addMonth();
        }

        // 5. Pesanan Terbaru
        $recentOrders = Order::with('user', 'items', 'payment')->latest()->take(7)->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'orderGrowth',
            'totalRevenue',
            'revenueGrowth',
            'activeTemplates',
            'templateGrowth',
            'months',
            'salesData',
            'recentOrders'
        ));
    }
}
