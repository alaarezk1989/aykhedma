<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\TicketRequest;
use App\Http\Services\TicketService;
use App\Models\Ticket;
use Illuminate\Routing\Controller;
use View;
use Auth;

class TicketsController extends BaseController
{
    protected $ticketService;
    public function __construct(TicketService $ticketService) {
        $this->ticketService = $ticketService;
    }

    public function myTickets()
    {
        $list = Ticket::with('assignee')->orderBy('id', 'DESC')->where('user_id','=',Auth::user()->id)->paginate(10);
        return View::make('web.tickets.myTickets', ['list' => $list]);
    }




}
