<?php

namespace App\Repositories;

use App\Models\Address;
use Auth;

class AddressRepository
{
    public function search($request)
    {
        $addresses = Address::with('location')->orderBy('id', 'DESC');

        $addresses->where('user_id', $request->get('user'));

        return $addresses;
    }
}
