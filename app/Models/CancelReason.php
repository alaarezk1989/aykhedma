<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class CancelReason extends Model
{
    use Translatable;
    protected $table = 'cancel_reasons';
    public $translatedAttributes = ['title'];

    protected $fillable = ['active'];
}
