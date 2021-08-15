<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

class ActualShipment extends Model
{
    use NodeTrait;
    use SoftDeletes;
    use Translatable;

    protected $table = 'actual_shipments';
    protected $appends = ['title'];
    public $translatedAttributes = [
        'title'
    ];

    protected $fillable = [
        'branch_id',
        'shipment_id',
        'parent_id',
        'from',
        'to',
        'one_address',
        'one_delivery_address_id',
        'cutoff',
        'from_time',
        'to_time',
        'capacity',
        'load',
        'vehicle_id',
        'driver_id',
        'status',
        'active'
    ];

    public function fromAddress()
    {
        return $this->belongsTo(Location::class, 'from', 'id');
    }

    public function toAddress()
    {
        return $this->belongsTo(Location::class, 'to', 'id');
    }

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'shipment_id', 'id')->orderBy('id', "DESC");
    }

    public function getTitleAttribute()
    {
        return $this->getTranslationByLocaleKey(app()->getLocale())->title;
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function deliveryPerson()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function children()
    {
        return $this->hasMany(ActualShipment::class, 'parent_id');
    }
}
