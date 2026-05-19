@extends('layouts.app')

@section('title', 'Invoice - ' . $transaction->invoice_number)
@section('page-title', 'Detail Invoice')

@push('styles')
<style>
    @media print {
        @page { size: portrait; margin: 0.5cm; }
        body { margin: 0; padding: 0 !important; background: white !important; }
        .no-print { display: none !important; }
        .invoice-box { 
            width: 100% !important; 
            height: auto !important; 
            margin: 0 !important; 
            padding: 0 !important; 
            border: none !important; 
            box-shadow: none !important; 
            background: white !important;
        }
        .container-fluid { padding: 0 !important; }
        .main-content { margin-left: 0 !important; padding: 0 !important; }
        .card { border: none !important; box-shadow: none !important; }
        .topbar, .sidebar, footer { display: none !important; }
    }
    
    .invoice-box {
        width: 11cm;
        min-height: 20cm;
        margin: auto;
        padding: 0.4cm;
        background: #fcfade; /* Light yellow to mimic the pad */
        border: 1px solid #ccc;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
        color: #000;
        font-size: 10px;
        line-height: 1.2;
    }
    
    .header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
    }
    .header-left {
        display: flex;
        align-items: flex-start;
        gap: 8px;
    }
    .jms-logo {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 2px;
    }
    
    .company-info {
        font-size: 11px;
    }
    .company-info h3 {
        margin: 0 0 1px 0;
        font-size: 15px;
        color: #000;
        font-weight: bold;
    }
    
    .header-right {
        font-size: 10px;
        text-align: left;
        width: 150px;
    }
    
    .invoice-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 5px;
    }
    .invoice-table th, .invoice-table td {
        border: 1px solid #000;
        padding: 6px 4px;
        font-size: 10px;
    }
    .invoice-table th {
        text-align: center;
        font-weight: normal;
    }
    
    .footer-left {
        font-size: 10px;
    }
    .signatures {
        display: flex;
        justify-content: space-around;
        margin-top: 15px;
    }
    .sig-box {
        text-align: center;
        font-size: 12px;
    }
</style>
@endpush

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 no-print">
    <div>
        <h5 class="mb-1 fw-700" style="color:#1e293b">Invoice - Ukuran 11cm x 20cm (Portrait)</h5>
    </div>
    <div class="d-flex gap-2">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="bi bi-printer me-2"></i>Cetak Invoice
        </button>
        <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="invoice-box">
    <!-- Header Section -->
    <div class="header">
        <div class="header-left">
            <div class="jms-logo">
                <img src="{{ asset('images/logo-jms.png') }}" alt="JMS Logo" style="width: 65px; height: 65px; object-fit: contain;">
            </div>
            <div class="company-info">
                <h3>JAYA MAKMUR SENTOSA</h3>
                <div>SUPPLIER HOSE, HYDRAULIC & FITTING</div>
                <div>Jl. Raya Serang - Banten</div>
                <div>Telp. 0813 1562 6225 / 0812 8874 1367</div>
                <div>E-mail : sujianto467@gmail.com</div>
            </div>
        </div>
        <div class="header-right">
            <div style="margin-bottom: 6px;">
                Tanggal : {{ strtoupper(\Carbon\Carbon::parse($transaction->tanggal)->translatedFormat('d F Y')) }}
            </div>
            <div>Kepada YTH</div>
            <div style="border-bottom: 1px dotted #000; width: 100%; height: 16px; margin-top: 3px;">
                <strong style="font-size:13px;">{{ $transaction->pembeli ?? '' }}</strong>
            </div>
            <div style="border-bottom: 1px dotted #000; width: 100%; height: 16px; margin-top: 5px;"></div>
        </div>
    </div>

    <!-- Pre-table info (Invoice Number) -->
    <div style="display: flex; justify-content: flex-end; margin-bottom: 3px; padding-right: 10px;">
        <div style="font-weight: bold; font-size: 14px;">
            INVOICE No : {{ $transaction->invoice_number }}
        </div>
    </div>

    <!-- Table -->
    <table class="invoice-table">
        <thead>
            <tr>
                <th colspan="2" style="width: 15%;">BANYAKNYA</th>
                <th style="width: 40%;">NAMA BARANG</th>
                <th style="width: 20%;">Harga Satuan</th>
                <th style="width: 25%;">JUMLAH</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaction->details as $detail)
            <tr>
                <td style="text-align: center;">{{ $detail->qty }}</td>
                <td style="text-align: center; font-size: 10px;">{{ $detail->product->unit ?? 'Pcs' }}</td>
                <td>{{ $detail->product->name ?? 'Produk dihapus' }}</td>
                <td>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Rp</span>
                        <span>{{ number_format($detail->harga, 0, ',', '.') }}</span>
                    </div>
                </td>
                <td>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Rp</span>
                        <span>{{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                    </div>
                </td>
            </tr>
            @endforeach
            
            <!-- Empty rows to pad the table -->
            @for($i=0; $i<max(0, 8 - count($transaction->details)); $i++)
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Rp</span>
                        <span></span>
                    </div>
                </td>
                <td>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Rp</span>
                        <span></span>
                    </div>
                </td>
            </tr>
            @endfor

            @php
                $total = $transaction->total;
                $discount = 0; // Fixed format as per image
                $grandTotal = $total - $discount;
            @endphp
            
            <!-- Footer Rows -->
            <tr>
                <td colspan="3" rowspan="3" style="vertical-align: top; border: none !important;">
                    <div class="footer-left">
                        <div style="margin-bottom: 15px; font-size: 9px;">
                            PEMBAYARAN TRANSFER KE REK a/n : SUJIANTO ac : 7110320170, Bank BCA
                        </div>
                        <div class="signatures">
                            <div class="sig-box">
                                Tanda Terima<br><br><br>
                                (.......................)
                            </div>
                            <div class="sig-box">
                                Hormat Kami<br><br><br>
                                (.......................)
                            </div>
                        </div>
                    </div>
                </td>
                <td>Total</td>
                <td>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Rp</span>
                        <span>{{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Discount</td>
                <td>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Rp</span>
                        <span>0</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Total Penjualan</td>
                <td>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Rp</span>
                        <span>{{ number_format($grandTotal, 0, ',', '.') }}</span>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

@if(session('success'))
<script>
    @if(str_contains(session('success'), 'berhasil disimpan'))
        window.onload = function() {
            // window.print();
        }
    @endif
</script>
@endif
@endsection
