<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Finance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class FinanceController extends Controller
{
    public function dashboard()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;

        $incomeToday = Finance::where('type', 'pemasukan')->whereDate('date', $today)->sum('amount');
        $expenseToday = Finance::where('type', 'pengeluaran')->whereDate('date', $today)->sum('amount');
        
        $incomeMonth = Finance::where('type', 'pemasukan')->whereMonth('date', $thisMonth)->whereYear('date', $thisYear)->sum('amount');
        $expenseMonth = Finance::where('type', 'pengeluaran')->whereMonth('date', $thisMonth)->whereYear('date', $thisYear)->sum('amount');

        $recentTransactions = Finance::latest()->take(10)->get();

        // Chart Data (Last 7 Days)
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartData['labels'][] = $date->format('d M');
            $chartData['income'][] = Finance::where('type', 'pemasukan')->whereDate('date', $date)->sum('amount');
            $chartData['expense'][] = Finance::where('type', 'pengeluaran')->whereDate('date', $date)->sum('amount');
        }

        return view('finance.dashboard', compact(
            'incomeToday', 'expenseToday', 'incomeMonth', 'expenseMonth', 
            'recentTransactions', 'chartData'
        ));
    }

    public function index(Request $request)
    {
        $query = Finance::query();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        $finances = $query->latest('date')->paginate(20)->withQueryString();
        
        return view('finance.index', compact('finances'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'        => 'required|in:pemasukan,pengeluaran',
            'amount'      => 'required|numeric|min:0',
            'date'        => 'required|date',
            'category'    => 'required|string|max:255',
            'description' => 'nullable|string',
            'proof_image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('proof_image')) {
            $data['proof_image'] = $request->file('proof_image')->store('finance', 'public');
        }

        Finance::create($data);

        return redirect()->route('finance.index')->with('success', 'Catatan keuangan berhasil disimpan.');
    }

    public function destroy(Finance $finance)
    {
        if ($finance->proof_image) {
            Storage::disk('public')->delete($finance->proof_image);
        }
        $finance->delete();
        return back()->with('success', 'Catatan keuangan berhasil dihapus.');
    }
}
