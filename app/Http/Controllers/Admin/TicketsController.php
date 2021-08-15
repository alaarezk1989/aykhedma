<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\TicketRequest;
use App\Http\Requests\Admin\TicketReplyRequest;
use App\Http\Services\TicketService;
use App\Repositories\TicketRepository ;
use App\Constants\TicketStatus as TicketStatus ;
use App\Constants\UserTypes as UserTypes;
use App\Models\Ticket;
use App\Models\TicketReasons;
use App\Models\TicketReply;
use App\Models\User;
use Illuminate\Routing\Controller;
use View;
use App\Repositories\UserRepository ;

class TicketsController extends BaseController
{
    protected $ticketService;
    protected $userRepository;
    protected $ticketRepository ;

    public function __construct(TicketService $ticketService, UserRepository $userRepository, TicketRepository $ticketRepository)
    {
        $this->authorizeResource(Ticket::class, "ticket");
        $this->ticketService = $ticketService;
        $this->userRepository= $userRepository ;
        $this->ticketRepository= $ticketRepository ;
    }

    public function index()
    {
        $this->authorize("index", Ticket::class);
        $status = TicketStatus::getList();
        $ticketReasons= TicketReasons::all();
        $ticketsCount = $this->ticketRepository->search(request())->count();
        $list = $this->ticketRepository->search(request())->paginate(10);
        $list->appends(request()->all());
        return View::make('admin.tickets.index', ['list' => $list , 'status' =>$status , 'ticketsCount'=>$ticketsCount, 'ticketReasons'=>$ticketReasons]);
    }

    public function create()
    {
        $ticketReasons= TicketReasons::all();
        $admins = $this->userRepository->admins()->get();

        return View::make('admin.tickets.new', compact('admins', 'ticketReasons'));
    }

    public function store(TicketRequest $request)
    {
        $this->ticketService->fillFromRequest($request);
        return redirect(route('admin.tickets.index'))->with('success', trans('item_added_successfully'));
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->back()->with('success', trans('item_deleted_successfully'));
    }

    public function edit(Ticket $ticket)
    {
        $admins = $this->userRepository->admins()->get();
        return View::make('admin.tickets.edit', ['ticket' => $ticket,'admins'=>$admins]);
    }

    public function update(TicketRequest $request, Ticket $ticket)
    {
        $this->ticketService->fillFromRequest($request, $ticket);
        return redirect(route('admin.tickets.index'))->with('success', trans('item_updated_successfully'));
    }

    public function details(Ticket $ticket)
    {
        $list = $ticket->replies;
        return View::make('admin.tickets.details', ['list' => $list, 'ticket'=>$ticket]);
    }

    public function reply(TicketReplyRequest $request, Ticket $ticket)
    {
        $this->ticketService->fillTicketReplyFromRequest($request);
        return redirect(route('admin.ticket.details', ['ticket'=>$ticket->id]));
    }

    public function export()
    {
        return $this->ticketService->export();
    }
}
