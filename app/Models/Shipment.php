<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

class Shipment extends Model
{
    use NodeTrait;
    use SoftDeletes;
    use Translatable;

    protected $table = 'shipments';
    protected $appends = ['title'];
    public $translatedAttributes = [
        'title'
    ];
    protected $fillable = [
        'parent_id',
        'branch_id',
        'from',
        'to',
        'one_address',
        'one_delivery_address_id',
        'cut_off_date',
        'capacity',
        'load',
        'vehicle_id',
        'driver_id',
        'recurring',
        'day',
        'from_time',
        'to_time',
        'last_touch',
        'active'
    ];

    public function getTitleAttribute()
    {
        return  $this->getTranslationByLocaleKey(app()->getLocale())->title;
    }

    public function fromAddress()
    {
        return $this->belongsTo(Location::class, 'from', 'id');
    }

    public function toAddress()
    {
        return $this->belongsTo(Location::class, 'to', 'id');
    }

    public function subShipments()
    {
        return $this->hasMany(Shipment::class, 'parent_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'shipment_id', 'id')
        ->Where('shipment_id', $this->id)->orWhereIn('shipment_id', $this->subShipments()->get()->toArray());
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function deliveryPerson()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
}
