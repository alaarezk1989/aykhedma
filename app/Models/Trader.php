<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trader extends Model
{
    use SoftDeletes;
    protected $table = 'traders';
    protected $fillable = ['user_id', 'commercial_register', 'tax_card', 'national_id', 'national_id_image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
