<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;

class ShippingCompanyTranslation extends Model
{
    protected $table = 'shipping_companies_translations';

    protected $fillable = ['name', 'address', 'shipping_company_id'];
}
