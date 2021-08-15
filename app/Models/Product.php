<?php

namespace App\Models;

use App\Events\ProductCreatedEvent;
use App\Events\ProductDeletedEvent;
use App\Events\ProductEditedEvent;
use App\Http\Services\UploaderService ;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    use Translatable;

    protected $appends = ['name', 'image'];

    public $translatedAttributes = [
        'name',
        "meta_title",
        "meta_description",
        "meta_keyword",
        "description"
    ];

    protected $fillable = [
        'unit_id',
        "category_id",
        "icon",
        "image",
        "unit_value",
        "code",
        "manufacturer",
        "created_by",
        "active",
        "bundle",
        "per_kilogram"
    ];

    public $dispatchesEvents = [
        'created' => ProductCreatedEvent::class,
        'updated' => ProductEditedEvent::class,
        'deleted' => ProductDeletedEvent::class
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class) ;
    }

    // declare event handlers
    public static function boot()
    {
        parent::boot();
        $uploaderService = new UploaderService();
        // before delete() method call this
        static::deleting(function ($product) use ($uploaderService) {
            foreach ($product->images as $image) {
                $uploaderService->deleteFile($image);
                $image->delete();
            }
            foreach ($product->branchProducts as $branchProduct) {
                $branchProduct->delete();
            }
        });
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_products', 'product_id', 'branch_id')
                ->withPivot('id', 'price', 'price', 'discount', 'discount_till', 'wholesale', 'active');
    }

    public function branchProducts()
    {
        return $this->hasMany(BranchProduct::class, "product_id");
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getNameAttribute()
    {
        return $this->getTranslationByLocaleKey(app()->getLocale())->name;
    }

    public function orderProduct()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function getImageAttribute()
    {
        return $this->images()->first();
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
