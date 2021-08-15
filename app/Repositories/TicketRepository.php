<?php

namespace App\Repositories;

use Symfony\Component\HttpFoundation\Request;
use App\Models\Ticket;
use Carbon\Carbon;

class TicketRepository
{
    public function search($request = null)
    {
        $tickets = Ticket::with(['user', 'replies'])->orderBy('id', 'DESC');

        if ($request->filled('from_date')) {
            $tickets->where('created_at', '>=', $request->get('from_date'));
        }
        if ($request->filled('to_date')) {
            $tickets->where('created_at', '<=', $request->get('to_date'));
        }
        if ($request->filled('status')) {
            $tickets->where('status', $request->get('status'));
        }
        if ($request->filled('assignee')) {
            if ($request->get('assignee') == "null") {
                $tickets->where('assignee_id', null);
                return $tickets;
            }

            $tickets->where('assignee_id', '<>', 'null');
        }
        if ($request->filled('filter_by')) {
            $tickets->where($request->get('filter_by'), $request->get('q'));
        }
        if ($request->filled('user_id')) {
            $tickets->where('user_id', $request->get('user_id'));
        }

        return $tickets;
    }

    public function ticketsGraph($request = [])
    {
        $tickets = Ticket::whereDate('created_at', '>', Carbon::now()->subMonth())
            ->orderBy('id', 'DESC');

        if (!empty($request)) {
            $tickets->where('status', $request['status']);
        }

        return $tickets;
    }
}
