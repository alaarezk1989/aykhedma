<?php

namespace App\Http\Services;

use App\Constants\TicketStatus;
use App\Constants\UserTypes;
use App\Jobs\CreateTicketNotification;
use App\Mail\CreateNewTicketMail;
use App\Mail\TicketReplayMail;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\User;
use Symfony\Component\HttpFoundation\Request;
use Auth;
use App\Http\Services\ExportService;
use App\Http\Resources\Tickets;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\TicketRepository;


class TicketService
{

    protected $ticketRepository ;
    protected $notificationService;

    public function __construct(TicketRepository $ticketRepository, NotificationService $notificationService)
    {
        $this->ticketRepository = $ticketRepository;
        $this->notificationService = $notificationService;
    }

    public function fillFromRequest(Request $request, $ticket = null)
    {
        if (!$ticket) {
            $ticket = new Ticket();
        }
        $ticket->fill($request->request->all());

        if ($request->isMethod('post')) {
            $ticket->user_id = auth()->user()->id;
        }

        if (!$request->filled('status')) {
            $ticket->status = TicketStatus::PENDING;
        }

        if ($request->filled('message')) {
            $ticket->description = $request->get('message');
        }

        $ticket->save();

        dispatch(new CreateTicketNotification($ticket));

        return $ticket;
    }

    public function fillTicketReplyFromRequest(Request $request, $ticketReply = null)
    {
        if (!$ticketReply) {
            $ticketReply = new TicketReply();
        }
        $ticketReply->fill($request->request->all());
        $ticketReply->save();

        $ticket = Ticket::find($request->get('ticket_id'));

        $this->notificationService->sendMail($ticket->user, new TicketReplayMail($ticketReply, $ticket->user));

        return $ticketReply;
    }

    public function export()
    {
        $headings = [
            [trans('tickets_list')],
            [
                '#',
                trans('user_name'),
                trans('title'),
                trans('description'),
                trans('assignee'),
                trans('status'),
                trans('created_at')
            ]
        ];
        $list = $this->ticketRepository->search(request())->get();
        $listObjects = Tickets::collection($list);

        return Excel::download(new ExportService($listObjects, $headings), 'Tickets Report.xlsx');
    }
}
