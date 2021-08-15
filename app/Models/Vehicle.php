<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use Translatable;
    use SoftDeletes;
    protected $table = 'vehicles';

    public $translatedAttributes = ['name'];
    protected $appends = array('name');

    protected $hidden = ['translations'];
    protected $fillable = ['type_id', 'status_id', 'zone_id', 'driver_id', 'capacity', 'shipping_company_id','number'];

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
    public function location()
    {
        return $this->belongsTo(Location::class, 'zone_id');
    }
    public function getNameAttribute()
    {
        return $this->getTranslationByLocaleKey(app()->getLocale())->name;
    }

    public function shipments()
    {
        return $this->hasMany(ActualShipment::Class);
    }
}
