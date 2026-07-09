<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
   

    protected $fillable = [
        'purchase_number', 'supplier_id', 'user_id', 'total_amount', 'purchase_date', 'notes'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(PurchaseDetail::class);
    }
}