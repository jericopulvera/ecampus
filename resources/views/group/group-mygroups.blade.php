@extends('templates.app')
@section('title')My groups @endsection

@section('content')
<nav class="panel container has-text-centered">
    @if(count($groups) > 0)
    <p class="panel-heading">
        Class Group List
    </p>
    <div class="panel-block">
        <div class="control table-responsive">
            <div class="table-responsive"  style="width: 100%; overflow-x:auto;">
                <table class="table no-margin is-bordered is-striped">
                    <thead>
                        <tr>
                            <th>Professor</th>
                            <th>Subject-section</th>
                            <th>Room</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Semester</th>
                            <th>Year</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach($groups as $group)
                        <tr>
                            <td><a href="{{ url('groups',$group->slug )}}">{!! $group->professor !!}</a></td>
                            <td><a href="{{ url('groups',$group->slug )}}">{!! $group->subject !!}</a></td>
                            <td><a href="{{ url('groups',$group->slug )}}">{!! $group->room !!}</a></td>
                            <td><a href="{{ url('groups',$group->slug )}}">{!! $group->start !!}</a></td>
                            <td><a href="{{ url('groups',$group->slug )}}">{!! $group->end !!}</a></td>
                            <td><a href="{{ url('groups',$group->slug )}}">{!! $group->term->semester !!}</a></td>
                            <td><a href="{{ url('groups',$group->slug )}}">{!! $group->term->year !!}</a></td>
                            @if($group->inGroup() == true)
                            <td><a href="{{ url('groups',$group->slug )}}" style='width: 100%;' class='button is-small is-info'>View</a></td>
                            @else
                            <td><a href='#' style='width: 100%;' class='button is-small is-warning disabled'>Pending</a></td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header with-border">
            </div>
            <!-- /.box-header -->
            <div class="box-body clearfix">
                <blockquote class="text-center">
                    <p>You have no class group yet...</p>
                    <small><cite title="Source Title">Anonymous</cite></small>
                </blockquote>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    @endif
</nav>


@endsection

@push('css')
<style scoped>
  tr:hover { 
     background: whitesmoke; 
  }
  td a { 
     display: block; 
     color: inherit;
  }
 </style>
@endpush
