<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;

class LocationTranslation extends Model
{

    protected $table = 'locations_translations';


    protected $fillable = ['name'];


    public function location()
    {
        return $this->hasMany('App\Location');
    }
}
