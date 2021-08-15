<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Voucher;

class deleteVouchers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $voucher;

    public function __construct(Voucher $voucher )
    {
        $this->voucher = $voucher ;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Voucher::where('parent_id', '=', $this->voucher->id)->delete();
    }
}
