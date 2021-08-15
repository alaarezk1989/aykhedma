<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use Translatable;
    use SoftDeletes;
    protected $appends = ['name'];
    public $translatedAttributes = ['name','address','activity','deleted_at'];
    protected $fillable = ['administrator','administrator_phone','administrator_email','administrator_job', 'mobile', 'phone', 'email', 'commercial_registration_no', 'tax_card', 'other'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
