@extends('templates.app')

@section('content')
    <div class="container">
    <div class="title">Event Information</div>
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
                {{ $calendar->title }}
          </p>
        </header>
        <div class="card-content">
          <div class="content">
            {{ $calendar->description }}
          </div>
        </div>
        @if (Auth::user()->privilege != 'Student')
        <footer class="card-footer">
          <a href="/calendar" class="card-footer-item">Back to Calendar</a>
          <a href="/calendar" class="card-footer-item" onclick="deleteEvent()">Delete Event</a>
        </footer>
        @endif
      </div>
    </div>

    <form action="{{url('calendar', $calendar->id)}}" method="POST" id="removeEvent">
          {{csrf_field()}}
          {{method_field('DELETE')}}
    </form>
@endsection

@push('js')
<script>
    function deleteEvent() {
         event.preventDefault(); 

         var confirm = window.confirm('Are you sure you want to delete this event?');

         if (confirm) {
             document.getElementById('removeEvent').submit();
         }
    }
    
</script>
@endpush