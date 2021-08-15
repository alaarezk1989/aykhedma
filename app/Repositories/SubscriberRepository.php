<?php

namespace App\Repositories;

use App\Models\Subscriber;
use Symfony\Component\HttpFoundation\Request;

class SubscriberRepository
{
    public function search(Request $request)
    {
        $subscribers = Subscriber::query()->orderByDesc("id");

        if ($request->has('email') && !empty($request->get('email'))) {
            $subscribers->where('email', 'like', '%' . $request->query->get('email') . '%');
        }

        return $subscribers;
    }
}
