@extends('admin.layout')

@section('content')
<!--app-content open-->
<div class="app-content">
	<section class="section">
		<!--page-header open-->
		<div class="page-header">
			<h4 class="page-title">{{ trans('ticket_details') }}</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/" class="text-light-color">{{trans('home')}}</a></li>
				<li class="breadcrumb-item"><a href="{{ route('admin.tickets.index') }}" class="text-light-color">{{trans('tickets')}}</a></li>
				<li class="breadcrumb-item active" aria-current="page">{{ $ticket->title }}</li>
			</ol>
		</div>
		<!--page-header closed-->
		<!--row open-->
		<div class="row">
			<div class="col-xl-9 col-lg-12 col-md-12">
				<div class="card">
					<div class="card-header">
						<h4 class="">{{ trans('ticket') }}</h4>
					</div>
					<div class="card-body">
						<div class="blog-icon mt-3 mb-3 d-flex">
							<a href="#" class="text-muted"><i class="fa fa-calendar-minus-o"></i> {{ $ticket->created_at }}</a>
						</div>
						<div class="media">
							<div class="media-left">
								@if($ticket->user->image)
								<img alt="64x64" src="{{ asset($ticket->user->image) }}" class="media-object">
								@else
								<img alt="64x64" src="{{ url('assets/img/avatar/avatar-3.jpeg') }}" class="media-object">
								@endif
							</div>

							<div class="media-body">
								<h4 class="media-heading">{{ $ticket->user->first_name." ".$ticket->user->last_name }}</h4>
							</div>
						</div>
						<h4 class="media-heading">{{ $ticket->title }}</h4>
						<p>{{ $ticket->description }}</p>
					</div>
				</div>
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">{{trans('replies')}}</h4>
					</div>
					<div class="card-body">
						@foreach ($list as $reply)
						<div class="col-md-12  mt-2 pb-2">
							<div class="media">
								<div class="media-left">
									@if($reply->user->image)
									<img alt="64x64" src="{{ asset($reply->user->image) }}" class="media-object">
									@else
									<img alt="64x64" src="{{ url('assets/img/avatar/avatar-3.jpeg') }}" class="media-object">
									@endif
								</div>
								<div class="media-body">
									<h4 class="media-heading">{{ $reply->user->first_name." ".$reply->user->last_name}}</h4>
									<p>{{ $reply->description }}</p>
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">{{trans('leave_a_reply')}}</h4>
					</div>
					@include('admin.errors')
					<form action="{{ route('admin.ticket.reply',['ticket'=>$ticket->id]) }}" method="post">
						@csrf
						<div class="card-body">
							<div class="form-group mb-0">
								<textarea class="form-control" placeholder="{{trans('write_reply')}}" name="description"rows="6"></textarea>
								<input type="hidden" name="user_id" value="{{auth()->user()->id}}">
								<input type="hidden" name="ticket_id" value="{{$ticket->id}}">
							</div>
						</div>
						<div class="card-footer">
							<button type="submit"class="btn btn-primary">{{trans('send')}}</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!--row closed-->
	</section>
</div>
<!--app-content closed-->
@stop
