<?php

namespace App\Models;

use App\Constants\OrderStatus;
use App\Events\OrderCreatedEvent;
use App\Events\OrderEditedEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'address_id',
        'branch_id',
        'status',
        'total_price',
        'preferred_delivery_time',
        'coupon_id',
        'discount_id',
        'voucher_id',
        'final_amount',
        'shipment_id',
        'type',
        'payment_type',
        'points_used',
        'promo_code',
        'expected_delivery_time',
        'driver_id',
    ];

    protected $appends = ['status_label'];

    public $dispatchesEvents = [
        'updated' => OrderEditedEvent::class,
        'created' => OrderCreatedEvent::class,
    ];

    public function products()
    {
        return $this->belongsToMany(BranchProduct::class, 'order_products', 'order_id', 'branch_product_id')
            ->withPivot('id', 'price', 'quantity')
            ->where('order_products.deleted_at', null);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function drivers()
    {
        return $this->belongsToMany(User::class, 'driver_orders', 'order_id', 'driver_id')
        ->withPivot('order_id', 'cancel_reason', 'driver_id', 'driver_comment', 'user_comment', 'status')
        ->withTimestamps();
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::Class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::Class);
    }

    public function getStatusLabelAttribute()
    {
        return OrderStatus::getValue($this->status);
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function getPromoTypeAttribute()
    {
        $promoCode = $this->promo_code;
        if ($promoCode) {
            if (Coupon::where('code', $promoCode)->first()) {
                return trans('coupon');
            }
            if ($promotion = Voucher::where('code', $promoCode)->first()) {
                return trans('voucher');
            }
        }
        return '-';
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'promo_code', 'code');
    }

    public function shipment()
    {
        return $this->belongsTo(ActualShipment::class, 'shipment_id');
    }
}
