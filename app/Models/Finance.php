<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $fillable = [
        'type',
        'amount',
        'date',
        'category',
        'reference_id',
        'description',
        'proof_image',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
