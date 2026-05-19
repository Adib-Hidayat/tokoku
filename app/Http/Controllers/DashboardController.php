<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\StockLog;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts   = Product::count();
        $totalCategories = Category::count();
        $totalStock      = Product::sum('stock');
        $totalTransaksi  = Transaction::count();
        $totalPendapatan = Transaction::where('status', 'selesai')->sum('total');
        $lowStockProducts = Product::where('stock', '<=', 5)->with('category')->get();
        $recentTransactions = Transaction::latest()->take(5)->get();
        $recentStockLogs = StockLog::with('product')->latest()->take(5)->get();

        // Chart data: transaksi per hari (7 hari terakhir)
        $chartLabels = [];
        $chartData   = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->format('d M');
            $chartData[]   = Transaction::whereDate('tanggal', $date->toDateString())
                ->where('status', 'selesai')
                ->sum('total');
        }

        return view('dashboard.index', compact(
            'totalProducts',
            'totalCategories',
            'totalStock',
            'totalTransaksi',
            'totalPendapatan',
            'lowStockProducts',
            'recentTransactions',
            'recentStockLogs',
            'chartLabels',
            'chartData'
        ));
    }
}
