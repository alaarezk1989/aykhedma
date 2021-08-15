<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;

class DiscountTranslation extends Model
{
    protected $table = 'discounts_translations';

    protected $fillable = ['title'];
}
