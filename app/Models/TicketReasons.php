<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketReasons extends Model
{
    use HasFactory;
    protected $table = "ticket_reasons" ;

    protected $fillable= ['title'];
}
