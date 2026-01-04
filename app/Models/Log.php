<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @property array user
 */
class Log extends Model
// class Log extends Eloquent
{
    // protected $connection = 'mongodb';

    protected $table = 'logs';
    protected $fillable = ['user_id','object_id','object_type','message','user'];

    protected $casts = [
        'user' => 'array',
    ];
}
