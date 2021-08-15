<?php

namespace App\Mail;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateCouponClientMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    /**
     * @var Coupon
     */
    public $coupon;
    public $user;

    public function __construct(Coupon $coupon, User $user)
    {
        $this->coupon = $coupon;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(trans('new_coupon'))->view('mails.client_new_coupon');
    }
}
