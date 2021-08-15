<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\Voucher;

class CreateVouchers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $voucher;

    public function __construct(Voucher $voucher)
    {
        $this->voucher = $voucher ;
    }

    public function handle()
    {
        for ($i = 1; $i <= $this->voucher->number; $i++) {
            $newVouchers= new Voucher();
            $newVouchers->code                = uniqueCode();
            $newVouchers->parent_id           = $this->voucher->id ;
            $newVouchers->expire_date         = $this->voucher->expire_date;
            $newVouchers->number              = $this->voucher->number;
            $newVouchers->value               = $this->voucher->value ;
            $newVouchers->vendor_id           = $this->voucher->vendor_id ;
            $newVouchers->branch_id           = $this->voucher->branch_id ;
            $newVouchers->activity_id         = $this->voucher->activity_id ;
            $newVouchers->segmentation_id     = $this->voucher->segmentation_id ;
            $newVouchers->company_id          = $this->voucher->company_id ;
            $newVouchers->active              = $this->voucher->active;
            $newVouchers->is_used             = $this->voucher->is_used;
            $newVouchers->save();
        }
    }
}
