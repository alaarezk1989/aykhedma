<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    protected $fillable = ['type','segmentation_id','title','body','banner'];

    public function segmentation()
    {
        return $this->belongsTo(Segmentation::class);
    }
}
