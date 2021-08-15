<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductTranslation extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'name',
        "meta_title",
        "meta_description",
        "meta_keyword",
        "description"
    ];
}
