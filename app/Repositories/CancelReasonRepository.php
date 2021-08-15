<?php

namespace App\Repositories;

use App\Models\CancelReason;
use Symfony\Component\HttpFoundation\Request;

class CancelReasonRepository
{
    public function search(Request $request)
    {
        $cancelReasons = CancelReason::query()->with('translations')->orderByDesc("id");

        if ($request->has('title') && !empty($request->get('title'))) {
            $cancelReasons->whereHas('translations', function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->query->get('title') . '%');
            });
        }
        if ($request->filled('active')) {
            $cancelReasons->where('active', true);
        }

        return $cancelReasons;
    }
}
