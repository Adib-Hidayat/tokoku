<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Finance;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function profitLoss(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        $income = Finance::where('type', 'pemasukan')
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('amount');

        $expense = Finance::where('type', 'pengeluaran')
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('amount');

        $profit = $income - $expense;

        // Details by category
        $incomeDetails = Finance::where('type', 'pemasukan')
            ->whereBetween('date', [$startDate, $endDate])
            ->selectRaw('category, sum(amount) as total')
            ->groupBy('category')
            ->get();

        $expenseDetails = Finance::where('type', 'pengeluaran')
            ->whereBetween('date', [$startDate, $endDate])
            ->selectRaw('category, sum(amount) as total')
            ->groupBy('category')
            ->get();

        return view('reports.profit_loss', compact(
            'income', 'expense', 'profit', 'incomeDetails', 'expenseDetails', 'startDate', 'endDate'
        ));
    }

    public function cashFlow(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        $logs = Finance::whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'asc')
            ->get();

        return view('reports.cash_flow', compact('logs', 'startDate', 'endDate'));
    }
}
