@extends('templates.app')

@section('content')

    <div class="container body">
        <newsfeed></newsfeed>
    </div>
    
@endsection

@push('server-to-vue')

@endpush

@push('css')
<link href="/css/styles.css" rel="stylesheet">
@endpush