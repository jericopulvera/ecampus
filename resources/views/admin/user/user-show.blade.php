@extends('admin.templates.app')

@section('content')

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <div class="pull-left">
                <h2>{{ $user->name }}</h2>
            </div>
            <div class="pull-right">
                <a href="{{ route('admin-edit-user', $user->usn) }}" type="submit" class="btn btn-success btn-xs'">Edit User</a>
           
                @if ($user->active === 1)
                <form action={!! route('admin-block-user', $user->usn) !!} method="POST">
                    {{csrf_field()}}
                    <button type="submit" class="btn btn-danger btn-xs'">Block</button>
                </form>
                @else
                <form action={!! route('admin-unblock-user', $user->usn) !!} method="POST">
                    {{ method_field('PATCH') }}
                    {{csrf_field()}}
                    <button type="submit" class="btn btn-info btn-xs'">Unblock</button>
                </form> 
                @endif
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
           
                @if ($user->privilege == 'Student')
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Grades
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action" id="grades">
                                    <thead>
                                        <tr class="headings">
                                            <th class="column-title">USN</th>
                                            <th class="column-title">Name</th>
                                            <th class="column-title">Course</th>
                                            <th class="column-title">Subject</th>
                                            <th class="column-title">Section</th>
                                            <th class="column-title">Grade</th>
                                            <th class="column-title">Final Mark</th>
                                            <th class="column-title">Academic Term</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="panel  panel-default">
                        <div class="panel-heading">
                            Schedule this semester
                        </div>
                        <div class="panel-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            
            </div>
        </div>
    </div>
</div>


@endsection

@push('admin-css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.13/r-2.1.1/datatables.min.css"/>
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

@push('admin-js')
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/r-2.1.1/datatables.min.js"></script>

    <script>

      $(function() {
            $('#grades').DataTable({
                processing: true,
                serverSide: false,
                ajax: '{!! route('admin-user-grades', $user->usn) !!}',
                columns: [
                    { data: 'USN', name: 'USN' },
                    { data: 'name', name: 'name' },
                    { data: 'course', name: 'course' },
                    { data: 'subject', name: 'subject' },
                    { data: 'section', name: 'section' },
                    { data: 'grade', name: 'grade' },
                    { data: 'mark', name: 'mark' },
                    { data: 'academic_term', name: 'term' },
                ]
            });
        });

    </script>

    <script src="{{ asset('dist/plugins/fullcalendar/moment.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/fullcalendar/fullcalendar.min.js') }}"></script>

    <script>
       var schedule = {!!$schedule!!};
    </script>

    <script>
    $('#calendar').fullCalendar({
        editable: false,
        header: {
            left: null,
            center: null,
            right: 'listWeek, agendaWeek'
        },
        defaultView: 'listWeek',
        events: schedule
    });
    </script>
@endpush
