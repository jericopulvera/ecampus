@extends('templates.auth')

@section('content')
    <auth></auth>
@endsection

@push('server-to-vue')
@if(Session::exists('facebook-id'))
<script> var facebook = {{ Session::get('facebook-id') }}; </script>
@else 
<script> var facebook = 0; </script>
@endif
@endpush