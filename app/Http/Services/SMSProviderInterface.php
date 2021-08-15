<?php
/**
 * Created by PhpStorm.
 * User: yehia
 * Date: 10/06/19
 * Time: 12:20 م
 */

namespace App\Http\Services;

use Illuminate\Contracts\Auth\Authenticatable;

interface SMSProviderInterface
{
    public function sendSMS(Authenticatable $user, string $text);
}
