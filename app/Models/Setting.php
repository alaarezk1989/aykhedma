<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Translatable;

    protected $fillable = [
        'key',
        'active',
    ];

    public $translatedAttributes = [
        "value",
    ];

    protected $appends = ['value'];

    public function getValueAttribute()
    {
        return $this->getTranslationByLocaleKey(app()->getLocale())->value;
    }
}
