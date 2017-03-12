@extends('templates.app')

@section('content')
    @if((auth()->id() === $user->id))
    <my-profile></my-profile>
    @else
    <search-profile></search-profile>
    @endif
@endsection

@push('server-to-vue')
    <script> 
    var user = {!! $user !!}; 
    </script>
@endpush

@push('css')
	<link rel="stylesheet" href="{{asset('css/profile.css')}}">

	<link href="{{ asset('dist/plugins/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet">
	<style>
	  #event-description {
	      white-space: -moz-pre-wrap; /* Firefox */
	      white-space: -pre-wrap; /* ancient Opera */
	      white-space: -o-pre-wrap; /* newer Opera */
	      white-space: pre-wrap; /* Chrome; W3C standard */
	      word-wrap: break-word; /* IE */
	  }

	  .fc-toolbar .fc-state-active, .fc-toolbar .ui-state-active {
	      z-index: 1;
	  }
	</style>  
@endpush

@push('js')

<script src="{{ asset('dist/plugins/fullcalendar/moment.min.js') }}"></script>
<script src="{{ asset('dist/plugins/fullcalendar/fullcalendar.min.js') }}"></script>

@endpush
