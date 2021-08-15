<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Repositories\OrderRepository;
use App\Repositories\TicketRepository;
use \App\Constants\TicketStatus;
use \App\Constants\OrderStatus;
use App\Constants\UserTypes;
use App\Repositories\UserRepository;
use View;

class HomeController extends BaseController
{
    protected $ticketRepository;
    protected $orderRepository;
    protected $userRepository;

    public function __construct(TicketRepository $ticketRepository, OrderRepository $orderRepository, UserRepository $userRepository)
    {
        $this->ticketRepository = $ticketRepository;
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        /** @var User $user */
        $user = auth()->user();
        $tickets = $this->buildTickets();
        $orders = $this->ordersCount();
        $users = $this->userCounts();

        return View::make('admin.home.index', ['tickets' => $tickets, 'orders' => $orders, 'users' => $users]);
    }

    private function buildTickets()
    {
        $tickets['submitted'] = $this->ticketRepository->ticketsGraph()->count();
        $tickets['pending'] = $this->ticketRepository->ticketsGraph(['status' => TicketStatus::PENDING])->count();
        $tickets['resolved'] = $this->ticketRepository->ticketsGraph(['status' => TicketStatus::RESOLVED])->count();

        return $tickets;
    }

    public function ordersCount()
    {
        $orders ['totalOrders'] = $this->orderRepository->search(request())->count();

        request()->query->set('status', OrderStatus::SUBMITTED);
        $orders ['submitted'] = $this->orderRepository->search(request())->count();

        request()->query->set('status', OrderStatus::CANCELLED);
        $orders ['cancelled'] = $this->orderRepository->search(request())->count();

        request()->query->set('status', OrderStatus::DELIVERED);
        $orders ['delivered'] = $this->orderRepository->search(request())->count();

        return $orders;
    }

    public function userCounts()
    {
        request()->query->set('type', UserTypes::NORMAL);
        $users['customers'] = $this->userRepository->search(request())->count();

        request()->query->set('type', UserTypes::VENDOR);
        $users['vendors'] = $this->userRepository->search(request())->count();

        request()->query->set('type', UserTypes::PUBLIC_DRIVER);
        $users['publicDrivers'] = $this->userRepository->search(request())->count();

        request()->query->set('type', UserTypes::DELIVERY_PERSONAL);
        $users['deliveryPerson'] = $this->userRepository->search(request())->count();

        return $users;
    }
}
