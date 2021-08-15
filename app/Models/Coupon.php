<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dimsav\Translatable\Translatable;

class Coupon extends Model
{

    use SoftDeletes;
    use Translatable;

    public $translatedAttributes = ['title'];

    protected $appends = ['title'];

    protected $fillable = ['branch_id','vendor_id','activity_id','minimum_order_price','code','active','type','value','expire_date', 'segmentation_id'];

    protected $table = 'coupones';

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function getTitleAttribute()
    {
        return $this->getTranslationByLocaleKey(app()->getLocale())->title;
    }

    public function segmentation()
    {
        return $this->belongsTo(Segmentation::class);
    }
}
