<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CouponTranslation extends Model
{
    use SoftDeletes;
    protected $table = 'coupones_translations';

    protected $fillable = ['title'];

}