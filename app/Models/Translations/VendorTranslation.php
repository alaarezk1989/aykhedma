<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;

class VendorTranslation extends Model
{
    protected $table = 'vendors_translations';

    protected $fillable = ['name','vendor_id'];
}
