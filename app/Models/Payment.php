<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = ['amount','order_id','coupon_id','discount_id','voucher_id','final_amount','taxes','fees','status','gateway','gateway_reference'];
}
