<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Services\CompanyService;
use App\Http\Requests\Admin\CompanyRequest;
use App\Repositories\CompanyRepository;
use App\Models\Company;
use App\Models\User;
use App\Http\Services\AuthService;


class CompanyController extends BaseController
{
    protected $companyService;
    protected $companyRepository;
    protected $authService;

    public function __construct(CompanyService $companyService, CompanyRepository $companyRepository, AuthService $authService)
    {
        $this->authorizeResource(Company::class, "company");
        $this->companyService = $companyService;
        $this->companyRepository = $companyRepository;
        $this->authService = $authService;
    }

    public function index(Request $request)
    {
        $this->authorize("index", Company::class);
        $list = $this->companyRepository->search(request())->paginate(10);
        $list->appends(request()->all());
        return View('admin.companies.index', compact('list'));
    }

    public function create()
    {
        return View('admin.companies.create');
    }

    public function store(CompanyRequest $request)
    {
        $this->companyService->fillFromRequest($request);
        return redirect(route('admin.companies.index'))->with('success', 'item added successfuly');
    }

    public function edit(Company $company)
    {
        return View('admin.companies.edit', compact('company'));
    }

    public function update(CompanyRequest $request, Company $company)
    {
        $this->companyService->fillFromRequest($request, $company);
        return redirect(route('admin.companies.index'))->with('success', 'item updated successfuly');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->back()->with('success', trans('item_deleted_successfully'));
    }

    public function getUsers(Company $company)
    {
        $this->authorize("users", Company::class);
        $users = User::where('company_id', $company->id)->paginate(10);
        return view('admin.companies.users', compact('users', 'company'));
    }


}
