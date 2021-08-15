<?php

namespace App\Http\Services;

use App\Jobs\CreateSubscribe;
use App\Models\Subscribe;
use App\Repositories\SubscribeRepository;
use Symfony\Component\HttpFoundation\Request;

class SubscribeService
{
    protected $uploaderService;
    protected $subscribeRepository;

    public function __construct(UploaderService $uploaderService, SubscribeRepository $subscribeRepository)
    {
        $this->uploaderService = $uploaderService;
        $this->subscribeRepository = $subscribeRepository;
    }

    public function fillFromRequest(Request $request, $subscribe = null)
    {
        if (!$subscribe) {
            $subscribe = new Subscribe();
        }

        if (!empty($request->file('banner'))) {
            $subscribe->banner = $this->uploaderService->upload($request->file('banner'), 'subscribes_banners');
        }

        $subscribe->fill($request->request->all());
        $subscribe->save();

        if ($request->isMethod('post')) {
            dispatch(new CreateSubscribe($subscribe));
        }

        return $subscribe;
    }
}
