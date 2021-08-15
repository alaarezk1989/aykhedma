<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Services\TicketService;
use Illuminate\Routing\Controller;
use App\Http\Requests\Api\ContactRequest ;

class TicketController extends Controller
{
    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function store(ContactRequest $request)
    {
        $this->ticketService->fillFromRequest($request);

        return response()->json(['success' => true, 'result' => trans('message_sent_successfully')]);
    }
}
