<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;

class CompanyTranslation extends Model
{
    protected $table = 'companies_translations';

    protected $fillable = ['name','address','activity','company_id'];
}
