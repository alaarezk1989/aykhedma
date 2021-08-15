<?php

namespace App\Models;

use App\Events\BranchProductCreatedEvent;
use App\Events\BranchProductDeletedEvent;
use App\Events\BranchProductEditedEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BranchProduct extends Model
{
    use SoftDeletes;

    protected $table = "branch_products";

    protected $fillable = [
        'branch_id',
        'product_id',
        "category_id",
        "price",
        "discount",
        "discount_till",
        "wholesale",
        "created_by",
        "updated_by",
        "deleted_by",
    ];

    public $dispatchesEvents = [
        'created' => BranchProductCreatedEvent::class,
        'updated' => BranchProductEditedEvent::class,
        'deleted' => BranchProductDeletedEvent::class
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get all of the branchProduct's reviews.
     */
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
