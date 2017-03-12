@extends('templates.app')
@section('title') {!! @$group->subject !!} @endsection

@section('content')
<div class="container">
 	<group></group>
</div>
@endsection

@push('server-to-vue')
<script>
	var group =  {!! $group !!} ;
</script>
@endpush
