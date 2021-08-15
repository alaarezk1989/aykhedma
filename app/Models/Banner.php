<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use File;

class Banner extends Model
{
    use SoftDeletes;

    protected $fillable = ['type','url','date_from','date_to', 'branch_id', 'image', 'active'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
