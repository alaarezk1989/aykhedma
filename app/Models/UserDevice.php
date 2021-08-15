<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDevice extends Model
{
     use SoftDeletes;
    
    protected $table = "user_devices";
    
    protected $fillable = ['user_id', 'model', 'os', 'token'];
   
    
}
