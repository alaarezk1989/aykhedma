<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    protected $table = "addresses";

    protected $fillable = [
        'user_id',
        'location_id',
        'long',
        'lat',
        "building",
        "street",
        "floor",
        "apartment",
    ];

    protected $hidden = ['location_id', 'user_id'];
    protected $with = ['user', 'location'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

}
