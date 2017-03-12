@extends('templates.app')

@section('content')

	<div class="container body">
		<div class=" event-timeline">
			<?php $users = App\User::all(); ?>
			<p>
			@foreach($users as $user)
				<p class="event-item">
					usn: <a>{!! $user->usn !!}</a> &nbsp;
					privilege: <a>{{ $user->privilege }}</a> &nbsp;
					password:<a>123123</a>
				</p>
				<hr>
			@endforeach
			</p>
		</div>
	</div>
  
@endsection

@push('server-to-vue')

@endpush