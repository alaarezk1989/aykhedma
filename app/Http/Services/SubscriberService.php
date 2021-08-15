<?php

namespace App\Http\Services;

use App\Models\Subscriber;
use Symfony\Component\HttpFoundation\Request;

class SubscriberService
{
    public function fillFromRequest(Request $request, $Subscriber = null )
    {
       
        if (!$Subscriber ){
            $Subscriber = new Subscriber();
        }
      
        $Subscriber->fill($request->request->all());
        $Subscriber->active = $request->request->get('active', 0);
        $Subscriber->save();
        return $Subscriber;

    }
}
