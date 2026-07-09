<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{

    protected $fillable = [
        'invoice_number', 'user_id', 'customer_name', 'total_amount',
        'discount', 'tax', 'grand_total', 'payment_amount', 'change_amount',
        'payment_method', 'sale_date'
    ];

    protected $casts = [
        'sale_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }
}