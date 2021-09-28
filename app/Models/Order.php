<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'advance',
        'due',
        'pay_by',
        'total_qty',
        'total_subtotal',
        'vat',
        'total',
        'order_date',
        'order_month',
        'order_year',
    ];

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }


}
