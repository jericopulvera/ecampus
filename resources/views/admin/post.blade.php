@extends('admin.templates.app')

@section('content')
<div class="row tile_count">
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Registered Users</span>
            <div class="count">2500</div>
    </div>

    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Registee Students</span>
            <div class="count">2500</div>
    </div>

    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Registee Professors</span>
            <div class="count">2500</div>
    </div>
</div>
@endsection

@push('admin-css')
    <link href="/admin/vendors/nprogress/nprogress.css" rel="stylesheet">
@endpush

@push('admin-js')
    <script src="/admin/vendors/echarts/dist/echarts.min.js"></script>
@endpush
