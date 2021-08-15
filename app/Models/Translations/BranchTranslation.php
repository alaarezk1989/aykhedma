<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;

class BranchTranslation extends Model
{
    protected $table = 'branches_translations';

    protected $fillable = ['name', 'address','branch_id'];
}
