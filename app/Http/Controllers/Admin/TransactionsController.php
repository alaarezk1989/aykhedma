<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\TransactionRequest;
use App\Http\Services\TransactionService;
use App\Models\Branch;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use App\Models\Vendor;
use App\Models\User;

use Illuminate\Support\Facades\Request;
use View;

class TransactionsController extends BaseController
{
    protected $transactionService;
    protected $transactionRepository;
    public function __construct(TransactionService $transactionService, TransactionRepository $transactionRepository)
    {
        $this->authorizeResource(Transaction::class, "transaction");
        $this->transactionService = $transactionService;
        $this->transactionRepository = $transactionRepository;
    }

    public function index()
    {
        $this->authorize("index", Transaction::class);
        $list = $this->transactionRepository->search(request())->paginate(10);
        $list->appends(request()->all());

        $count = $this->transactionRepository->search(request())->count();

        $users = User::whereNotIn('id', [1,2])->get();
        $branches = Branch::where('active', 1)->get();

        $totalBalance = 0;
        if (Request::get('vendor_id') != "") {
            $totalBalance = $this->transactionRepository->search(request())->limit(1)->value('balance');
        }

        return View::make('admin.transactions.index', ['list' => $list, 'branches' => $branches, 'users' => $users, 'totalBalance' => $totalBalance, 'count' => $count]);
    }

    public function create()
    {
        $users = User::all();
        $vendors = Vendor::where('active', 1)->get();
        $orders = Order::all();
        $payments = Payment::where('invoice_number', '<>', null)->get();

        return View::make('admin.transactions.new', ['users' => $users, 'vendors' => $vendors, 'orders' => $orders, 'payments' => $payments]);
    }

    public function store(TransactionRequest $request)
    {
        $this->transactionService->fillFromRequest($request);
        return redirect(route('admin.transactions.index'))->with('success', trans('transaction_added_successfully'));
    }

    public function export()
    {
        return $this->transactionService->export();
    }
}
