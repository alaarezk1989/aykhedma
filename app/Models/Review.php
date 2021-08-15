<?php

namespace App\Models;

use App\Events\VendorReviewsCreatedEvent;
use App\Events\VendorReviewsDeletedEvent;
use App\Events\VendorReviewsEditedEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Review extends Model
{
    use SoftDeletes;

    protected $table = "reviews";

    protected $fillable = [
        'user_id',
        "rate",
        "review",
        'reviewable_id',
        'reviewable_type',
    ];

    /**
     * Get the owning reviewable model.
     */
    public function reviewable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedatAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }

    public $dispatchesEvents = [
        'deleted' => VendorReviewsDeletedEvent::class,
        'created' => VendorReviewsCreatedEvent::class,
        'updated' => VendorReviewsEditedEvent::class,
    ];
}
