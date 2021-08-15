<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\SubscribeRequest;
use App\Http\Services\SubscribeService;
use App\Models\Segmentation;
use App\Models\Subscribe;
use App\Repositories\SubscribeRepository;
use View;

class SubscribeController extends BaseController
{
    protected $subscribeService;
    protected $subscribeRepository;

    public function __construct(SubscribeService $subscribeService, SubscribeRepository $subscribeRepository)
    {
        $this->authorizeResource(Subscribe::class, "subscribe");
        $this->subscribeService = $subscribeService;
        $this->subscribeRepository = $subscribeRepository;
    }

    public function index()
    {
        $this->authorize("index", Subscribe::class);
        $list = $this->subscribeRepository->search(request())->paginate(10);

        return View::make('admin.subscribes.index', ['list' => $list]);
    }

    public function create()
    {
        $segmentations = Segmentation::all();

        return View::make('admin.subscribes.new', ['segmentations' => $segmentations]);
    }

    public function store(SubscribeRequest $request)
    {
        $this->subscribeService->fillFromRequest($request);

        return redirect(route('admin.subscribes.index'))->with('success', trans('subscribed_successfully'));
    }
}
