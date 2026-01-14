<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';

    protected $fillable = ['amount','order_id','coupon_id','discount_id','voucher_id','final_amount','taxes','fees','status','gateway','gateway_reference'];
}
