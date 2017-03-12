@extends('templates.app')
@section('title')Groups @endsection
@section('content')
    <div class="panel container has-text-centered">
        <p class="panel-heading">
            Group
        </p>
        <div class="panel-block">
            <div class="control">
                <a href="/groups/list" class="button is-info is-fullwidth" style="margin: 10px;"><span class="fa fa-list"></span>&nbsp;Group List</a>
                <a href="/groups/my-groups" class="button is-info is-fullwidth" style="margin: 10px;"><span class="fa fa-list-alt"></span>&nbsp;My Groups</a>
                @if (Auth::user()->privilege != 'Student')
                    <a href="/groups/create" class="button is-info is-fullwidth" style="margin: 10px;"><span class="fa fa-plus"></span>&nbsp;Create Group</a>
                @endif
            </div>
        </div>
    </div>
    
@endsection
