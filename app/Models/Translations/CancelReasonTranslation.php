<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;

class CancelReasonTranslation extends Model
{
    protected $table = 'cancel_reasons_translations';

    protected $fillable = ['title'];
}
