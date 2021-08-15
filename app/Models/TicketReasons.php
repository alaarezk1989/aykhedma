<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketReasons extends Model
{
    protected $table = "ticket_reasons" ;

    protected $fillable= ['title'];
}
