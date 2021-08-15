<?php

namespace App\Models;

use App\Events\UnitDeletedEvent;
use App\Events\UnitEditedEvent;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use Translatable;
    use SoftDeletes;
    protected $table = 'units';
    public $translatedAttributes = ['name', 'acronym'];

    protected $fillable = ['active'];

    public $dispatchesEvents = [
        'updated' => UnitEditedEvent::class,
        'deleted' => UnitDeletedEvent::class
    ];
}
