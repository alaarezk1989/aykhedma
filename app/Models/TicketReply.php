<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\TicketReplyCreatedEvent;

class TicketReply extends Model
{
	use SoftDeletes;
	protected $table    = 'ticket_replies';
	protected $fillable = ['user_id', 'ticket_id', 'description'];

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}


    public $dispatchesEvents = [
       
        'created' => TicketReplyCreatedEvent::class
    ];
}
