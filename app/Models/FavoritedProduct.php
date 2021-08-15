<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FavoritedProduct extends Model
{
    use SoftDeletes;

    protected $table = "favorited_products";

    protected $fillable = [
        'branch_product_id',
        'user_id',
    ];

    public function product()
    {
        return $this->belongsTo(BranchProduct::class);
    }
}
