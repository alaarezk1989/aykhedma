<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Web\SubscriberRequest;
use App\Http\Services\SubscriberService;
use App\Models\Subscriber;
use Illuminate\Routing\Controller;
use View;

class SubscribersController extends BaseController
{
    protected $subscriberService; 
    public function __construct(SubscriberService $subscriberService) {
        $this->subscriberService = $subscriberService;
    }

    public function subscribe(SubscriberRequest $request)
    {
        $subscruber = Subscriber::where('email', '=', $request->input('email'))->first();
        if (!$subscruber) {
            $this->subscriberService->fillFromRequest($request);
        }
        session()->flash('success', trans('you_subscribed_successfully'));
        return redirect()->back();
    }
}
