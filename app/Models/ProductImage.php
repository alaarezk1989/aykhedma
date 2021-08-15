<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use File;

class ProductImage extends Model
{
    use SoftDeletes;

    protected $fillable = ["product_id", "image"];

    public function Product()
    {
        return $this->belongsTo(Product::class) ;
    }

    // declare event handlers
    public static function boot()
    {
        parent::boot();

        // before delete() method call this
        static::deleting(function ($image) {
            $image_path = public_path().$image->image;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        });
    }
}
