<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Debt;
use App\Models\DebtPayment;
use Carbon\Carbon;

class DebtController extends Controller
{
    public function index(Request $request)
    {
        $query = Debt::query();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $debts = $query->latest()->paginate(15)->withQueryString();
        return view('debts.index', compact('debts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'     => 'required|in:hutang,piutang',
            'name'     => 'required|string|max:255',
            'amount'   => 'required|numeric|min:0',
            'due_date' => 'nullable|date',
        ]);

        Debt::create($request->all());

        return redirect()->route('debts.index')->with('success', 'Data hutang/piutang berhasil ditambahkan.');
    }

    public function pay(Request $request, Debt $debt)
    {
        $request->validate([
            'amount'       => 'required|numeric|min:1|max:' . ($debt->amount - $debt->total_paid),
            'payment_date' => 'required|date',
            'note'         => 'nullable|string',
        ]);

        $debt->payments()->create([
            'amount'       => $request->amount,
            'payment_date' => $request->payment_date,
            'note'         => $request->note,
        ]);

        $debt->increment('total_paid', $request->amount);

        if ($debt->total_paid >= $debt->amount) {
            $debt->update(['status' => 'lunas']);
        }

        return back()->with('success', 'Pembayaran cicilan berhasil dicatat.');
    }

    public function destroy(Debt $debt)
    {
        $debt->delete();
        return back()->with('success', 'Data berhasil dihapus.');
    }
}
