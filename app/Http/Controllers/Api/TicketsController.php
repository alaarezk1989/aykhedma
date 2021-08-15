<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\TicketRequest;
use App\Http\Services\TicketService;
use App\Repositories\TicketRepository;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class TicketsController extends Controller
{
    protected $ticketService;
    protected $ticketRepository;

    public function __construct(TicketService $ticketService, TicketRepository $ticketRepository)
    {
        $this->ticketService = $ticketService;
        $this->ticketRepository = $ticketRepository;
    }

    public function index()
    {
        request()->request->add(['user_id' => auth()->user()->id]);
        $tickets = $this->ticketRepository->search(request())->paginate(10);

        return response()->json($tickets);
    }

    public function store(TicketRequest $request)
    {
        $ticket = $this->ticketService->fillFromRequest($request);

        return response($ticket, Response::HTTP_CREATED);
    }
}
