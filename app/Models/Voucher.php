<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use Translatable;
    use SoftDeletes;
    protected $table = 'vouchers';
    public $translatedAttributes = ['title'];
    protected $fillable = ['code','parent_id', 'expire_date', 'number', 'value', 'vendor_id', 'branch_id', 'activity_id', 'segmentation_id', 'company_id', 'is_used', 'active'];

    public function used($voucher)
    {
        return Voucher::where([['parent_id', $voucher], ['is_used', 1]])->count();
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
