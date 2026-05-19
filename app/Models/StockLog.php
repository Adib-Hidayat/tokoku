<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    protected $fillable = [
        'product_id', 'tipe', 'jumlah', 'keterangan', 'tanggal'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
