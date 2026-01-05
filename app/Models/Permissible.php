<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Permissible extends Model
{
    use HasFactory;
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
