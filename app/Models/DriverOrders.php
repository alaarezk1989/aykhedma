<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DriverOrders extends Model
{
    use SoftDeletes;

    protected $table = "driver_orders";

    protected $fillable = ['status', 'order_id', 'driver_id', 'cancel_reason', 'driver_comment', 'user_comment', 'start_location', 'end_location'];


    public function driver()
    {
        return $this->belongsToMany(user::class, 'driver_orders', 'id', 'driver_id')
            ->withPivot('driver_id', 'order_id');
    }


}
