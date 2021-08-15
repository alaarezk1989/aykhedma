<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;

class UnitTranslation extends Model
{

    protected $table = 'units_translations';


    protected $fillable = ['name', 'acronym'];
}
