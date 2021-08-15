<?php

namespace App\Models;

use App\Events\BranchZonesEditedEvent;
use App\Events\BranchZonesCreatedEvent;
use App\Events\BranchZonesDeletedEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BranchZone extends Model
{
    use SoftDeletes;

    protected $table = "branch_zones";

    protected $fillable = [
        'branch_id',
        'zone_id',
        'delivery_sla',
        'delivery_fee'
    ];

    public function zone()
    {
        return $this->belongsTo(Location::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public $dispatchesEvents = [
        'updated' => BranchZonesEditedEvent::class,
        'created' => BranchZonesCreatedEvent::class,
        'deleted' => BranchZonesDeletedEvent::class,
    ];
}
