<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\GroupPermissionEditedEvent;
use App\Events\GroupPermissionCreatedEvent;
use App\Events\GroupPermissionDeletedEvent;

class GroupPermission extends Model
{

    protected $table = 'group_permissions';
    protected $fillable = ['permission_id', 'group_id', 'data'];

    public $dispatchesEvents = [

        'updated' => GroupPermissionEditedEvent::class,
        'created' => GroupPermissionCreatedEvent::class,
        'deleted' => GroupPermissionDeletedEvent::class,

    ];
}
