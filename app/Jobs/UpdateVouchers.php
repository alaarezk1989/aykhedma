<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Voucher;

class UpdateVouchers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $voucher;

    public function __construct(Voucher $voucher)
    {
        $this->voucher = $voucher ;
    }


    public function handle()
    {
        $vouchers=Voucher::where('parent_id', $this->voucher->id)->get();
        foreach ($vouchers as $voucher) {
            $voucher->parent_id           = $this->voucher->id ;
            $voucher->expire_date         = $this->voucher->expire_date;
            $voucher->number              = $this->voucher->number;
            $voucher->value               = $this->voucher->value ;
            $voucher->vendor_id           = $this->voucher->vendor_id ;
            $voucher->branch_id           = $this->voucher->branch_id ;
            $voucher->activity_id         = $this->voucher->activity_id ;
            $voucher->segmentation_id     = $this->voucher->segmentation_id ;
            $voucher->company_id          = $this->voucher->company_id ;
            $voucher->active              = $this->voucher->active;
            $voucher->is_used             = $this->voucher->is_used;
            $voucher->save();
        }
    }
}
