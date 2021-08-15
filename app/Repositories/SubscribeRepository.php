<?php

namespace App\Repositories;

use App\Models\Subscribe;
use Symfony\Component\HttpFoundation\Request;

class SubscribeRepository
{
    public function search(Request $request)
    {
        $subscribes = Subscribe::query()->orderByDesc("id");

        return $subscribes;
    }
}
