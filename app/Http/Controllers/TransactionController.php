<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use App\Models\StockLog;
use App\Models\Finance;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::latest();

        if ($request->filled('search')) {
            $query->where('invoice_number', 'like', '%' . $request->search . '%')
                  ->orWhere('pembeli', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transactions = $query->paginate(15)->withQueryString();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::with('category')->where('stock', '>', 0)->orderBy('name')->get();
        return view('transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pembeli'        => 'nullable|string|max:255',
            'catatan'        => 'nullable|string',
            'payment_method' => 'required|string',
            'items'          => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty'        => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $total = 0;
            $details = [];

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                if ($product->stock < $item['qty']) {
                    throw new \Exception("Stok produk '{$product->name}' tidak mencukupi. Tersedia: {$product->stock}");
                }
                $subtotal  = $product->price * $item['qty'];
                $total    += $subtotal;
                $details[] = [
                    'product'  => $product,
                    'qty'      => $item['qty'],
                    'harga'    => $product->price,
                    'subtotal' => $subtotal,
                ];
            }

            $transaction = Transaction::create([
                'invoice_number' => Transaction::generateInvoiceNumber(),
                'tanggal'        => now()->toDateString(),
                'total'          => $total,
                'status'         => 'selesai',
                'pembeli'        => $request->pembeli,
                'catatan'        => $request->catatan,
                'payment_method' => $request->payment_method,
                'payment_status' => 'sukses',
            ]);

            foreach ($details as $d) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $d['product']->id,
                    'qty'            => $d['qty'],
                    'harga'          => $d['harga'],
                    'subtotal'       => $d['subtotal'],
                ]);

                // Kurangi stok
                $d['product']->decrement('stock', $d['qty']);

                // Log stok keluar
                StockLog::create([
                    'product_id'  => $d['product']->id,
                    'tipe'        => 'keluar',
                    'jumlah'      => $d['qty'],
                    'keterangan'  => 'Penjualan - ' . $transaction->invoice_number,
                    'tanggal'     => $transaction->tanggal->toDateString(),
                ]);
            }

            // Catat ke Keuangan (Finance)
            Finance::create([
                'type'         => 'pemasukan',
                'amount'       => $total,
                'date'         => now()->toDateString(),
                'category'     => 'Penjualan',
                'reference_id' => $transaction->invoice_number,
                'description'  => 'Penjualan produk via POS (' . strtoupper($request->payment_method) . ')',
            ]);

            DB::commit();
            return redirect()->route('transactions.show', $transaction)
                ->with('success', 'Transaksi berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('details.product.category');
        return view('transactions.show', compact('transaction'));
    }

    public function destroy(Transaction $transaction)
    {
        DB::beginTransaction();
        try {
            foreach ($transaction->details as $detail) {
                // Kembalikan stok
                $detail->product->increment('stock', $detail->qty);

                // Log stok masuk (pembatalan)
                StockLog::create([
                    'product_id'  => $detail->product_id,
                    'tipe'        => 'masuk',
                    'jumlah'      => $detail->qty,
                    'keterangan'  => 'Pembatalan transaksi - ' . $transaction->invoice_number,
                    'tanggal'     => now()->toDateString(),
                ]);
            }

            // Hapus atau batalkan record keuangan terkait
            Finance::where('reference_id', $transaction->invoice_number)->delete();

            $transaction->update(['status' => 'dibatalkan']);
            DB::commit();
            return redirect()->route('transactions.index')
                ->with('success', 'Transaksi berhasil dibatalkan, stok dikembalikan, dan catatan keuangan dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal membatalkan transaksi: ' . $e->getMessage());
        }
    }

    public function forceDelete(Transaction $transaction)
    {
        DB::beginTransaction();
        try {
            $transaction->details()->delete();
            $transaction->delete();
            DB::commit();
            return redirect()->route('transactions.index')
                ->with('success', 'Transaksi berhasil dihapus secara permanen.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }
}
