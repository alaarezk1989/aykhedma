<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\ShippingCompanyRequest;
use App\Http\Services\ShippingCompanyService;
use App\Models\ShippingCompany;
use App\Repositories\ShippingCompanyRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use View;


class ShippingCompaniesController extends BaseController
{
    protected $shippingCompanyService;
    private $shippingCompanyRepository;


    public function __construct(ShippingCompanyService $shippingCompanyService, ShippingCompanyRepository $shippingCompanyRepository)
    {
        $this->authorizeResource(ShippingCompany::class, "shippingCompany");
        $this->shippingCompanyService = $shippingCompanyService;
        $this->shippingCompanyRepository = $shippingCompanyRepository;
     
    }

    public function index(Request $request)
    {
        $this->authorize("index", ShippingCompany::class);
        $list = $this->shippingCompanyRepository->searchFromRequest(request());
        $list = $list->paginate(10);
        $list->appends(request()->all());
        return View::make('admin.shippingCompanies.index', ['list' => $list]);
    }

    public function create()
    {
        return View::make('admin.shippingCompanies.new');
    }

    public function store(ShippingCompanyRequest $request)
    {
        $this->shippingCompanyService->fillFromRequest($request);
        return redirect(route('admin.shippingCompanies.index'))->with('success', trans('item_added_successfully'));
    }

    public function destroy(ShippingCompany $shippingCompany)
    {
        
        $shippingCompany->delete();

        return redirect()->back()->with('success', trans('item_deleted_successfully'));
    }


    public function edit(ShippingCompany $shippingCompany)
    {
        return View::make('admin.shippingCompanies.edit', ['shippingCompany' => $shippingCompany]);
    }

    public function update(ShippingCompanyRequest $request, ShippingCompany $shippingCompany)
    {
        $this->shippingCompanyService->fillFromRequest($request, $shippingCompany);

        return redirect(route('admin.shippingCompanies.index'))->with('success', trans('item_updated_successfully'));
    }
}
