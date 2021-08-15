<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Revenue extends Model
{
    use SoftDeletes;

    protected $fillable = ['accountable_id', 'accountable_type', "amount", "balance", "payment_method", "type", "order_id"];

    public function accountable()
    {
        return $this->morphTo();
    }
}
