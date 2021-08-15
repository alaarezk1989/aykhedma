<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\ActivityEditedEvent;
use App\Events\ActivityDeletedEvent;
use App\Events\ActivityCreatedEvent;

class Activity extends Model
{
    use Translatable;
    use SoftDeletes;
    protected $table = 'activities';
    public $translatedAttributes = ['name','description', 'deleted_at'];
    protected $appends = array('name', 'description');

    protected $hidden = ['translations'];
    protected $fillable = ['active'];


    /**
     */
    public function getNameAttribute()
    {
        return $this->getTranslationByLocaleKey(app()->getLocale())->name;
    }

    /**
     */
    public function getDescriptionAttribute()
    {
        return $this->getTranslationByLocaleKey(app()->getLocale())->description;
    }

    public $dispatchesEvents = [
        'updated' =>ActivityEditedEvent::class,
        'deleted' =>ActivityDeletedEvent::class,
        'created' =>ActivityCreatedEvent::class,
    ];

    public function vendors()
    {
        return $this->hasMany(Vendor::class);
    }
}
