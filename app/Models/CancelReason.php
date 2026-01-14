<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class CancelReason extends Model
{
    use HasFactory;
    use Translatable;
    protected $table = 'cancel_reasons';
    public $translatedAttributes = ['title'];

    protected $fillable = ['active'];
}
