<?php

namespace App\Http\Services;

use App\Models\Log;
use Symfony\Component\HttpFoundation\Request;

class LogsService
{
    /**
     * @param $objectId
     * @param $objectType
     * @param $message
     *
     * @return Log|bool
     */
    public function fillLog($objectId, $objectType, $message)
    {
        if (auth()->check()) {
            $log = new Log();
            $log->user_id = auth()->user()->id;
            $log->object_id = $objectId;
            $log->object_type = $objectType;
            $log->message = $message;
            $log->user = auth()->user()->toArray();
            $log->save();

            return $log;
        }

        return false;
    }
}
