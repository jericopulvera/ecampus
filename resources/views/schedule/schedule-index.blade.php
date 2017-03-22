@extends('templates.app')

@section('content')
<nav class="panel container">
    <p class="panel-heading is-clearfix">
        <span class="is-pulled-left">
        @if(auth()->user()->id === $user->id)
            Your Schedule
        @else
            {{ $user->name }} - Schedule
        @endif
        </span>
        {{-- <span class="is-pulled-right">
            @if(auth()->user()->id === $user->id)
                <a href="/{{$user->usn}}">Go back to profile page</a>
            @else
                <a href="/{{$user->usn}}">Click to view profile</a>
            @endif
        </span> --}}
    </p>
    <div class="panel-block" >
        <div class="control">
            <div id="calendar"></div>
        </div>
    </div>
</nav>

@endsection

@push('css')
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

    <script>
       var schedule = {!!$schedule!!};
    </script>

    <script>
    $('#calendar').fullCalendar({
        editable: false,
        header: {
            left: null,
            center: null,
            right: 'listWeek'
        },
        defaultView: 'listWeek',
        events: schedule
    });
    </script>

@endpush
