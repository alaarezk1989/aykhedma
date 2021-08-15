<?php
/**
 * Created by PhpStorm.
 * User: yehia
 * Date: 23/06/19
 * Time: 11:55 ص
 */

namespace App\Http\Services;

use App\Models\User;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Nexmo\Client;
use Nexmo\Client\Credentials\Basic;

class NexmoSMSService implements SMSProviderInterface
{
    private $basic;
    private $client;

    /**
     * SMSService constructor.
     */
    public function __construct()
    {
        $this->basic = new Basic(env('NEXMO_KEY'), env('NEXMO_SECRET'));
        $this->client = new Client($this->basic);
    }

    /**
     * @param  Authenticatable  $user
     * @param  string  $text
     *
     * @return bool
     */
    public function sendSMS(Authenticatable $user, string $text)
    {
        try {
            $message = $this->client->message()->send([
                'to' => $user->phone,
                'from' => env("SMS_FROM"),
                'text' => $text
            ]);
            $response = $message->getResponseData();
            if ($response['messages'][0]['status'] != 0) {
                return false;
            }

            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
