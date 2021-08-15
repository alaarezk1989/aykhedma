<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Segmentation extends Model
{
    use Translatable;
    use SoftDeletes;
    protected $table = 'segmentations';
    public $translatedAttributes = ['title', 'deleted_at'];

    protected $fillable = ['class', 'location_id', 'location_class', 'company_id', 'orders_category', 'orders_wish_list_category', 'orders_amount', 'users_number', 'weeks_number'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
