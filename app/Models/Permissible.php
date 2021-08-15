<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permissible extends Model
{
    protected $table = "user_permissible";

    protected $fillable = [
        'user_id',
        'permissible_id',
        'permissible_type',
    ];

    public function permissible()
    {
        return $this->morphTo();
    }
}
