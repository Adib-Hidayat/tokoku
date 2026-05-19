<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockLog;
use App\Models\Product;
use App\Models\Category;

class StockController extends Controller
{
    /**
     * Menampilkan Stok Saat Ini
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
        }

        $products   = $query->join('categories', 'products.category_id', '=', 'categories.id')
                            ->select('products.*')
                            ->orderBy('categories.name', 'asc')
                            ->orderBy('products.code', 'asc')
                            ->paginate(15)
                            ->withQueryString();
        $categories = Category::orderBy('name')->get();
        $lowStock   = Product::where('stock', '<=', 5)->count();

        return view('stock.index', compact('products', 'categories', 'lowStock'));
    }

    /**
     * Menampilkan Riwayat Stok
     */
    public function history(Request $request)
    {
        $query = StockLog::with('product.category')->latest();

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }
        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $logs     = $query->paginate(20)->withQueryString();
        $products = Product::orderBy('name')->get();

        return view('stock.history', compact('logs', 'products'));
    }

    public function restock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'jumlah'     => 'required|integer|min:1',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($request->product_id);

        $product->increment('stock', $request->jumlah);

        StockLog::create([
            'product_id'  => $product->id,
            'tipe'        => 'masuk',
            'jumlah'      => $request->jumlah,
            'keterangan'  => $request->keterangan ?? 'Restock manual',
            'tanggal'     => now()->toDateString(),
        ]);

        return back()->with('success', "Stok produk '{$product->name}' berhasil ditambah {$request->jumlah} unit.");
    }
}
