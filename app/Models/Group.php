<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\GroupEditedEvent;
use App\Events\GroupDeletedEvent;
use App\Events\GroupCreatedEvent;
class Group extends Model
{

    use Translatable;
    use SoftDeletes;

    protected $table = 'groups';
    public $translatedAttributes = ['name'];
    protected $fillable = ['active', 'type'];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'active' => 0
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_groups', 'group_id', 'user_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'group_permissions', 'group_id', 'permission_id')->withPivot("data", "id");
    }

    public $dispatchesEvents = [
        'updated' => GroupEditedEvent::class,
        'deleted' => GroupDeletedEvent::class,
        'created' => GroupCreatedEvent::class
    ];
}
