<?php

namespace App\Models;

use App\Events\BranchDeletedEvent;
use App\Events\BranchEditedEvent;
use App\Events\BranchCreatedEvent;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use Translatable;
    use SoftDeletes;
    protected $table = 'branches';
    public $translatedAttributes = ['name', 'address', 'deleted_at'];


    protected $fillable = ['vendor_id', 'active', 'lat', 'lng','type','start_working_hours','end_working_hours','min_order_amount','aykhedma_fee'];
    protected $appends = ['name'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'branch_products', 'branch_id', 'product_id')

               ->withPivot('id', 'price', 'discount', 'discount_till', 'wholesale', 'active')
               ->where('branch_products.deleted_at', null);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function zones()
    {
        return $this->belongsToMany(Location::class, 'branch_zones', 'branch_id', 'zone_id')
            ->withPivot('id', 'delivery_sla', 'delivery_fee', 'deleted_at')
            ->where('branch_zones.deleted_at', null);
    }

    public $dispatchesEvents = [
        'updated' => BranchEditedEvent::class,
        'deleted' => BranchDeletedEvent::class,
        'created' => BranchCreatedEvent::class
    ];

    public function banners()
    {
        return $this->hasMany(Banner::class);
    }

    /**
     * @return mixed
     */
    public function getNameAttribute()
    {
        return $this->getTranslationByLocaleKey(app()->getLocale())->name;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'branch_products', 'branch_id', 'category_id')
            ->where('branch_products.deleted_at', null);
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable')->where('published', 1);
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'accountable');
    }

    public function permissible()
    {
        return $this->morphMany(Permissible::class, 'permissible');
    }

    public function scopeWithReviewableSum($query)
    {
        if (is_null($query->getQuery()->columns)) {
            $query->select($query->getQuery()->from . '.*');
        }

        $query->selectSub(function ($query) {
            $query->selectRaw('avg(rate)')
                ->from('reviews')
                ->whereColumn('reviews.reviewable_id', 'branches.id')
                ->where('reviews.published', 1);
        }, 'reviewable_avg');

        return $query;
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
