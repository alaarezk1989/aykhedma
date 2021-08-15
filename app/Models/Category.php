<?php

namespace App\Models;

use App\Events\CategoryDeletedEvent;
use App\Events\CategoryEditedEvent;
use App\Events\CategoryCreatedEvent;
use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use NodeTrait;
    use Translatable;
    use SoftDeletes;

    protected $table = 'categories';
    public $translatedAttributes = ['name'];
    protected $appends = ['name'];
    protected $hidden = ['translations'];
    protected $fillable = ['active', 'parent_id', 'image'];
    protected $with = ['children'];

    public function getNameAttribute()
    {
        return $this->getTranslationByLocaleKey(app()->getLocale())->name;
    }

    public $dispatchesEvents = [
        'updated' => CategoryEditedEvent::class,
        'deleted' => CategoryDeletedEvent::class,
        'created' => CategoryCreatedEvent::class
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
