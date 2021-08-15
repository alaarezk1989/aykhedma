<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;

class SegmentationTranslation extends Model
{
    protected $table = 'segmentations_translations';

    protected $fillable = ['title'];
}
