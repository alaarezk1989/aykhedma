<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;

class ActivityTranslation extends Model
{

    protected $table = 'activities_translations';


    protected $fillable = ['name', 'description'];
}
