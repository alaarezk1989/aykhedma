<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActualShipmentTranslation extends Model
{
    use SoftDeletes;
    protected $table = 'actual_shipments_translations';
    protected $fillable = [
        'title'
    ];
}
