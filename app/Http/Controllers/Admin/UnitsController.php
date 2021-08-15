<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\UnitRequest;
use App\Http\Services\UnitService;
use App\Models\Unit;
use App\Repositories\UnitRepository;
use Illuminate\Routing\Controller;
use View;

class UnitsController extends BaseController
{

    protected $unitService;
    private $unitRepository;

    public function __construct(UnitService $unitService, UnitRepository $unitRepository)
    {
        $this->authorizeResource(Unit::class, "unit");
        $this->unitService = $unitService;
        $this->unitRepository = $unitRepository;
    }

    public function index()
    {
        $this->authorize("index", Unit::class);

        $list = $this->unitRepository->search(request())->paginate(10);

        $list->appends(request()->all());

        return View::make('admin.units.index', ['list' => $list]);
    }

    public function create()
    {
        return View::make('admin.units.new');
    }

    public function store(UnitRequest $request)
    {
        $this->unitService->fillFromRequest($request);
        return redirect(route('admin.units.index'))->with('success', trans('item_added_successfully'));
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();

        return redirect()->back()->with('success', trans('item_deleted_successfully'));
    }

    public function edit(Unit $unit)
    {
        return View::make('admin.units.edit', ['unit' => $unit]);
    }

    public function update(UnitRequest $request, Unit $unit)
    {
        $this->unitService->fillFromRequest($request, $unit);

        return redirect(route('admin.units.index'))->with('success', trans('item_updated_successfully'));
    }

}
