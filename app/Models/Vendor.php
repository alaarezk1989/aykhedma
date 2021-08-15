<?php

namespace App\Models;

use App\Constants\UserTypes;
use App\Events\VendorDeletedEvent;
use App\Events\VendorEditedEvent;
use App\Events\VendorCreatedEvent;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use Translatable;
    use SoftDeletes;
    protected $table = 'vendors';
    public $translatedAttributes = ['name'];

    protected $fillable = ['activity_id', 'logo', 'active', 'type','administrator','administrator_phone','administrator_email','administrator_job', 'mobile', 'phone', 'email', 'commercial_registration_no', 'tax_card', 'other'];

    protected $appends = ['name'];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    /**
     * Get all of the vendor's reviews.
     */
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public $dispatchesEvents = [
        'updated' => VendorEditedEvent::class,
        'deleted' => VendorDeletedEvent::class,
        'created' => VendorCreatedEvent::class
    ];

    /**
     * @return mixed
     */
    public function getNameAttribute()
    {
        return $this->getTranslationByLocaleKey(app()->getLocale())->name;
    }

    public function admins()
    {
        return $this->hasMany(User::class)->where('type', UserTypes::VENDOR);
    }

    public function revenues()
    {
        return $this->morphMany(Revenue::class, 'accountable');
    }
}
