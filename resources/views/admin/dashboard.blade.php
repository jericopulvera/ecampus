@extends('admin.templates.app')

@section('content')
<div class="row tile_count">
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Registered Users</span>
            <div class="count">{{$total}}</div>
    </div>

    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Registered Professors</span>
            <div class="count">{{$professors}}</div>
    </div>

    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Registered Students</span>
            <div class="count">{{$students}}</div>
    </div>

    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-plus"></i> F and IC Students This Semester</span>
            <div class="count">{{$failAndIc}}</div>
    </div>

    
</div>
@endsection
