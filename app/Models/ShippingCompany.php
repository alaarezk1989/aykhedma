<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\ShippingCompanyEditedEvent;
use App\Events\ShippingCompanyDeletedEvent;
use App\Events\ShippingCompanyCreatedEvent;

class ShippingCompany extends Model
{
    use Translatable;
    use SoftDeletes;
    protected $table = 'shipping_companies';
    public $translatedAttributes = ['name','address'];
    protected $appends = array('name', 'description');

    protected $hidden = ['translations'];
    protected $fillable = ['active', 'administrator','administrator_phone','administrator_email','administrator_job', 'mobile', 'phone', 'email', 'commercial_registration_no', 'tax_card', 'other'];


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
        'updated' =>ShippingCompanyEditedEvent::class,
        'deleted' =>ShippingCompanyDeletedEvent::class,
        'created' =>ShippingCompanyCreatedEvent::class,
    ];

}








