<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    protected $fillable = [
        'type',
        'name',
        'amount',
        'total_paid',
        'due_date',
        'status',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function payments()
    {
        return $this->hasMany(DebtPayment::class);
    }
}
