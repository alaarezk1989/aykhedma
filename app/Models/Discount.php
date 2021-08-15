<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use Translatable;
    use SoftDeletes;

    public $translatedAttributes = ['title'];
    protected $fillable = ['activity_id',
                            'vendor_id',
                            'branch_id',
                            'from_date',
                            'to_date',
                            'value',
                            'type',
                            'minimum_order_price',
                            'usage_no',
                            'active',
                            'created_at'];
    protected $appends = array('title');
    protected $hidden = ['translations'];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
