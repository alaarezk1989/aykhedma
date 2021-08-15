<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Point extends Model
{
    use SoftDeletes;

    protected $table = "points";

    protected $fillable = [
        'user_id',
        "amount",
        "balance",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
