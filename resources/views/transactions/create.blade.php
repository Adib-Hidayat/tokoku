@extends('layouts.app')

@section('title', 'Transaksi Baru')
@section('page-title', 'Transaksi Baru')

@push('styles')
<style>
.product-select-item {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 12px;
    cursor: pointer;
    transition: all 0.2s;
    position: relative;
}
.product-select-item:hover { border-color: #6366f1; background: #f5f3ff; }
.product-select-item.selected { border-color: #6366f1; background: #f5f3ff; }
.product-select-item .check-icon {
    position: absolute; top: 8px; right: 8px;
    width: 22px; height: 22px;
    background: #6366f1;
    border-radius: 50%;
    display: none; align-items: center; justify-content: center;
    color: #fff; font-size: 0.7rem;
}
.product-select-item.selected .check-icon { display: flex; }
#cartTable tbody tr:last-child td { border-bottom: none; }
.qty-btn {
    width: 28px; height: 28px;
    border: 1px solid #e2e8f0;
    background: #f8fafc;
    border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: 0.85rem;
    transition: all 0.15s;
}
.qty-btn:hover { background: #6366f1; color: #fff; border-color: #6366f1; }
</style>
@endpush

@section('content')
<div class="row g-4">
    <!-- Product Selection -->
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-box-seam me-2 text-primary"></i>Pilih Produk</span>
                <input type="text" id="productSearch" class="form-control form-control-sm" style="width:200px"
                    placeholder="Cari produk..." oninput="filterProducts(this.value)">
            </div>
            <div class="card-body" style="max-height:480px;overflow-y:auto">
                <div class="row g-3" id="productGrid">
                    @foreach($products as $product)
                        <div class="col-6 product-item"
                            data-name="{{ strtolower($product->name) }}"
                            data-code="{{ strtolower($product->code) }}">
                            <div class="product-select-item" onclick="toggleProduct({{ $product->id }}, this)"
                                data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}"
                                data-price="{{ $product->price }}"
                                data-stock="{{ $product->stock }}">
                                <div class="check-icon"><i class="bi bi-check"></i></div>
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt=""
                                        style="width:100%;height:80px;object-fit:cover;border-radius:8px;margin-bottom:8px">
                                @else
                                    <div style="width:100%;height:80px;background:#f1f5f9;border-radius:8px;display:flex;align-items:center;justify-content:center;margin-bottom:8px;color:#94a3b8;font-size:1.5rem">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                                <div style="font-size:0.82rem;font-weight:600;color:#1e293b;margin-bottom:2px">{{ $product->name }}</div>
                                <div style="font-size:0.72rem;color:#94a3b8">{{ $product->category->name ?? '' }}</div>
                                <div style="font-size:0.85rem;font-weight:700;color:#6366f1;margin-top:4px">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </div>
                                <span class="badge {{ $product->stock <= 5 ? 'bg-warning text-dark' : 'bg-success' }}" style="font-size:0.68rem">
                                    Stok: {{ $product->stock }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($products->count() == 0)
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-box-seam" style="font-size:2.5rem;display:block;margin-bottom:8px"></i>
                        Tidak ada produk dengan stok tersedia
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Cart & Checkout -->
    <div class="col-lg-5">
        <form action="{{ route('transactions.store') }}" method="POST" id="checkoutForm">
            @csrf
            <div class="card mb-4">
                <div class="card-header"><i class="bi bi-cart me-2 text-primary"></i>Keranjang</div>
                <div class="card-body p-0">
                    <table class="table mb-0" id="cartTable">
                        <thead>
                            <tr>
                                <th style="width:40%">Produk</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="cartBody">
                            <tr id="emptyCart">
                                <td colspan="4" class="text-center py-4 text-muted" style="font-size:0.85rem">
                                    <i class="bi bi-cart" style="font-size:1.5rem;display:block;margin-bottom:6px"></i>
                                    Pilih produk untuk ditambahkan
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-body border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-600" style="color:#1e293b">Total</span>
                        <span id="totalDisplay" style="font-size:1.2rem;font-weight:700;color:#6366f1">Rp 0</span>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header"><i class="bi bi-person me-2 text-primary"></i>Info Pembeli</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Pembeli</label>
                        <input type="text" name="pembeli" class="form-control" placeholder="Opsional...">
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="2" placeholder="Catatan tambahan..."></textarea>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header"><i class="bi bi-wallet2 me-2 text-primary"></i>Metode Pembayaran</div>
                <div class="card-body">
                    <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>
                        <option value="tunai">Tunai / Cash</option>
                        <option value="transfer">Transfer Bank</option>
                        <option value="qris">QRIS / E-Wallet</option>
                        <option value="cod">COD (Bayar di Tempat)</option>
                    </select>
                    @error('payment_method')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div id="itemInputs"></div>

            <button type="submit" class="btn btn-primary w-100 py-3" id="submitBtn" disabled>
                <i class="bi bi-check-lg me-2"></i>Proses Transaksi
            </button>
            <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
let cart = {};

function toggleProduct(id, el) {
    if (cart[id]) {
        removeFromCart(id);
        el.classList.remove('selected');
    } else {
        cart[id] = {
            id: id,
            name: el.dataset.name,
            price: parseFloat(el.dataset.price),
            stock: parseInt(el.dataset.stock),
            qty: 1
        };
        el.classList.add('selected');
        renderCart();
    }
}

function removeFromCart(id) {
    delete cart[id];
    const el = document.querySelector(`[data-id="${id}"]`);
    if (el) el.classList.remove('selected');
    renderCart();
}

function changeQty(id, delta) {
    if (!cart[id]) return;
    cart[id].qty = Math.max(1, Math.min(cart[id].stock, cart[id].qty + delta));
    renderCart();
}

function renderCart() {
    const body = document.getElementById('cartBody');
    const inputsDiv = document.getElementById('itemInputs');
    const submitBtn = document.getElementById('submitBtn');
    const emptyCart = document.getElementById('emptyCart');
    const ids = Object.keys(cart);

    if (ids.length === 0) {
        body.innerHTML = `<tr id="emptyCart"><td colspan="4" class="text-center py-4 text-muted" style="font-size:0.85rem">
            <i class="bi bi-cart" style="font-size:1.5rem;display:block;margin-bottom:6px"></i>Pilih produk untuk ditambahkan</td></tr>`;
        inputsDiv.innerHTML = '';
        document.getElementById('totalDisplay').textContent = 'Rp 0';
        submitBtn.disabled = true;
        return;
    }

    let html = '';
    let inputHtml = '';
    let total = 0;
    let i = 0;

    ids.forEach(id => {
        const item = cart[id];
        const subtotal = item.price * item.qty;
        total += subtotal;
        html += `
            <tr>
                <td style="font-size:0.82rem;font-weight:600;color:#1e293b">${item.name}</td>
                <td>
                    <div class="d-flex align-items-center gap-1">
                        <div class="qty-btn" onclick="changeQty(${id}, -1)"><i class="bi bi-dash"></i></div>
                        <span style="min-width:24px;text-align:center;font-size:0.9rem;font-weight:600">${item.qty}</span>
                        <div class="qty-btn" onclick="changeQty(${id}, 1)"><i class="bi bi-plus"></i></div>
                    </div>
                </td>
                <td style="font-size:0.82rem;font-weight:600;color:#6366f1">
                    Rp ${new Intl.NumberFormat('id').format(subtotal)}
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeFromCart(${id})" style="padding:2px 8px">
                        <i class="bi bi-x"></i>
                    </button>
                </td>
            </tr>`;
        inputHtml += `<input type="hidden" name="items[${i}][product_id]" value="${id}">
                      <input type="hidden" name="items[${i}][qty]" value="${item.qty}">`;
        i++;
    });

    body.innerHTML = html;
    inputsDiv.innerHTML = inputHtml;
    document.getElementById('totalDisplay').textContent = 'Rp ' + new Intl.NumberFormat('id').format(total);
    submitBtn.disabled = false;
}

function filterProducts(q) {
    q = q.toLowerCase();
    document.querySelectorAll('.product-item').forEach(el => {
        const name = el.dataset.name;
        const code = el.dataset.code;
        el.style.display = (!q || name.includes(q) || code.includes(q)) ? '' : 'none';
    });
}
</script>
@endpush
