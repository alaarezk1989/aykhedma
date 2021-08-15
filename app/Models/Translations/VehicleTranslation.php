<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;

class VehicleTranslation extends Model
{

    protected $table = 'vehicles_translations';


    protected $fillable = ['name'];
}
