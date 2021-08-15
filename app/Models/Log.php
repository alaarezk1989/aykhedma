<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

/**
 * @property array user
 */
class Log extends Eloquent
{
    protected $connection = 'mongodb';
    protected $fillable = ['user_id','object_id','object_type','message','user'];
}
