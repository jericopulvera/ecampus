@extends('templates.app')

@section('content')
	
    <div class="container body">
    	<notification-page></notification-page>
    </div>
    
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('css/styles.css')}}">
@endpush
@push('server-to-vue')

@endpush