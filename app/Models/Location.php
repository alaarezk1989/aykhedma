<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
use App\Events\LocationDeletedEvent ;
use App\Events\LocationUpdatedEvent ;
use App\Events\LocationCreatedEvent ;

class Location extends Model
{
    use NodeTrait;
    use Translatable;
    use SoftDeletes;

    protected $table = 'locations';
    public $translatedAttributes = ['name'];
    protected $appends = ['name'];
    protected $fillable = ['active','long','lat', 'class', 'parent_id'];

    public function getNameAttribute()
    {
        return $this->getTranslationByLocaleKey(app()->getLocale())->name;
    }

    public function branch()
    {
        return $this->belongsToMany(Location::class);
    }

    public $dispatchesEvents = [

        'updated' => LocationUpdatedEvent::class,
        'deleted' => LocationDeletedEvent::class,
        'created' => LocationCreatedEvent::class,
    ];

    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_zones', 'zone_id', 'branch_id')
            ->withPivot('id', 'delivery_sla', 'delivery_fee', 'deleted_at')
            ->where('branch_zones.deleted_at', null);
    }

    public function parent()
    {
        return $this->belongsTo(Location::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Location::class, 'parent_id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
