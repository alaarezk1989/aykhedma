<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;

class VoucherTranslation extends Model
{

    protected $table = 'vouchers_translations';


    protected $fillable = ['title'];


    public function voucher()
    {
        return $this->hasMany('App\Voucher');
    }
}
