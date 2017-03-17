@extends('templates.app')

@section('content')

<div class="container body">
  <div class="panel">
      <div class="panel-heading">
        School Calendar
      </div>
      <div class="panel-block">
        <div class="control">
          <div id="calendar"></div>
        </div>
      </div>
  </div>
        

</div>

<!-- CREATE EVENT -->
@if(Auth::user()->privilege != 'Student')
<div class="modal" id="create-event">
    <div class="modal-background"></div>
    <div class="modal-card">
        <form action="{{ url('calendar') }}" method="POST" role="form">
            {{csrf_field()}}
            <header class="modal-card-head">
                <p class="modal-card-title">Create Event</p>
                <button class="delete" id="closeCreateModal"></button>
            </header>
            <section class="modal-card-body">
                
                <label class="label">Title</label>
                <p class="control">
                    <input class="input" type="text" placeholder="Event Title" name="title">
                </p>
                <label class="label">Description</label>
                <p class="control">
                    <textarea class="textarea" placeholder="Event Description" name="description"></textarea>
                </p>
                <input type="hidden" id="day" name="day">
            </section>
            <footer class="modal-card-foot">
                <button type="submit" class="button is-success" id="add-event">Add Event</button>
            </footer>
        </form>
    </div>
</div>
@endif
@endsection

@push('css')
  <link href="{{ asset('dist/plugins/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet">
  <style>
    td:hover {
      cursor: pointer;
    }

    .fc-day:hover {
        background: whitesmoke;
    }

    #event-description {
        white-space: -moz-pre-wrap; /* Firefox */
        white-space: -pre-wrap; /* ancient Opera */
        white-space: -o-pre-wrap; /* newer Opera */
        white-space: pre-wrap; /* Chrome; W3C standard */
        word-wrap: break-word; /* IE */
    }
  </style>  
@endpush


@push('js')

<script src="{{ asset('dist/plugins/fullcalendar/moment.min.js') }}"></script>
<script src="{{ asset('dist/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
<script src="{{ asset('dist/plugins/fullcalendar/gcal.min.js') }}"></script>

<script>
   var event = {!!$events!!};
   var date = new Date();
</script>

<script>
$(document).ready(function() {
    $('#closeCreateModal').click(function () {
        event.preventDefault();
        $("#create-event").removeClass('is-active');
    });
  });

$('#calendar').fullCalendar({
  defaultDate: date,
  displayEventTime: false,
  editable: false,
  eventLimit: true, // allow "more" link when too many events
  events: event,
    eventClick:  function(event, jsEvent, view) {
    window.location.href = '/calendar/event/'+event.id;
},
    dayClick: function(date, jsEvent, view) {
        $("#create-event").addClass("is-active");
        $("#day").val(date._d);
    },
});
</script>

<script>
  $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
  });

</script>

@if (notify()->ready())
    <script>
        swal({
            imageUrl: "{{ notify()->option('imageUrl') }}", 
            title: "{!! notify()->message() !!}",
            text: "{!! notify()->option('text') !!}",
            type: "{{ notify()->type() }}",
            @if (notify()->option('timer'))
                timer: {{ notify()->option('timer') }},
                showConfirmButton: false
            @endif
        });
    </script>
    {{ Session::forget(notify()->message()) }}
@else
@endif


@endpush
