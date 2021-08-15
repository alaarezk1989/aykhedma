<?php

namespace App\Http\Resources;

use App\Constants\OrderTypes;
use App\Constants\TransactionTypes;
use Illuminate\Http\Resources\Json\Resource;

class Transactions extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'accountable_id' => $this->accountable->name,
            'debit' => $this->debit,
            'credit' => $this->credit,
            'balance'=> $this->balance,
            'order_id'=> $this->order_id,
            'order_type'=>$this->order ? OrderTypes::getOne($this->order->type): '-',
            'transaction_type'=>TransactionTypes::getOne($this->transaction_type),
            'description'=> $this->description,
            'created_at'=> $this->created_at,
        ];
    }
}
