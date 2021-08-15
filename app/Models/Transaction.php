<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = ['debit','credit','balance','description','accountable_id','accountable_type','order_id','invoice_id', 'transaction_type'];

    /**
     * Get the owning account model.
     */
    public function accountable()
    {
        return $this->morphTo();
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
