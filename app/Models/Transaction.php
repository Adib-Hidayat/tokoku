<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'invoice_number', 'tanggal', 'total',
        'status', 'catatan', 'pembeli', 'payment_method', 'payment_status'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'total' => 'decimal:2',
    ];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function getFormattedTotalAttribute()
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }

    public static function generateInvoiceNumber()
    {
        $romans = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        $month = date('n');
        $romanMonth = $romans[$month];
        $year = date('Y');
        
        $prefix = '/AJMS/INV/' . $romanMonth . '/' . $year;
        
        $last = self::where('invoice_number', 'like', '%/AJMS/INV/%/' . $year)
            ->orderBy('id', 'desc')
            ->first();

        if ($last) {
            $parts = explode('/', $last->invoice_number);
            $lastNum = (int) $parts[0];
            return str_pad($lastNum + 1, 6, '0', STR_PAD_LEFT) . $prefix;
        }
        return '000001' . $prefix;
    }
}
