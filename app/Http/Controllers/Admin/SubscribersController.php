<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\SubscriberRequest;
use App\Http\Services\SubscriberService;
use App\Models\Subscriber;
use App\Repositories\SubscriberRepository;
use Illuminate\Routing\Controller;
use View;

class SubscribersController extends BaseController
{
    protected $subscriberService;
    protected $subscriberRepository;

    public function __construct(SubscriberService $subscriberService, SubscriberRepository $subscriberRepository)
    {
        $this->authorizeResource(Subscriber::class, "subscriber");
        $this->subscriberService = $subscriberService;
        $this->subscriberRepository = $subscriberRepository;
    }

    public function index()
    {
        $this->authorize("index", Subscriber::class);

        $list = $this->subscriberRepository->search(request())->paginate(10);

        return View::make('admin.subscribers.index', ['list' => $list]);
    }

    public function create()
    {
        return View::make('admin.subscribers.new');
    }

    public function store(SubscriberRequest $request)
    {
        $this->subscriberService->fillFromRequest($request);
        return redirect(route('admin.subscribers.index'))->with('success', trans('item_added_successfully'));
    }

    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();

        return redirect()->back()->with('success', trans('item_deleted_successfully'));
    }


    public function edit(Subscriber $subscriber)
    {
        return View::make('admin.subscribers.edit', ['subscriber' => $subscriber]);
    }

    public function update(SubscriberRequest $request, Subscriber $subscriber)
    {
        $this->subscriberService->fillFromRequest($request, $subscriber);

        return redirect(route('admin.subscribers.index'))->with('success', trans('item_updated_successfully'));
    }
}
