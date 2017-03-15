@extends('templates.app')
@section('title')Groups @endsection
@section('content')

<nav class="panel container has-text-centered">
    <p class="panel-heading">
        Class Group List
    </p>
    <div class="panel-block">
        <div class="control table-responsive">
            <table class="table is-bordered is-striped" id="groups-table">
                <thead>
                    <tr>
                        <th>Professor</th>
                        <th>Subject</th>
                        <th>Section</th>
                        <th>Room</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Semester</th>
                        <th>Year</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</nav>
@endsection
@push('css')
 
<link rel="stylesheet" href="/css/datatable/dataTables.bulma.min.css" />
@endpush
@push('js')
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/fc-3.2.2/fh-3.1.2/datatables.min.js"></script>
<script src="/js/datatable/dataTables.bulma.min.js"></script>
<script>

  $(function() {
        $('#groups-table').DataTable({
            lengthChange: false,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: true,
            ajax: '{!! url('/webapi/group/datatables') !!}',
            columns: [
                { data: 'professor', name: 'professor' },
                { data: 'subject', name: 'subject' },
                { data: 'section', name: 'section' },
                { data: 'room', name: 'room' },
                { data: 'start', name: 'start' },
                { data: 'end', name: 'end' },
                { data: 'term.semester', name: 'semester' },
                { data: 'term.year', name: 'year' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });

  function joinRequest(id)
  {
     $.ajax({
         type: 'POST',
         url: '{{ url('/webapi/group/join-request') }}',
         data: {
           _token: $('meta[name="csrf-token"]').attr('content'),
             group_id: id,
         },
         success: function(response) {
          if(response == 1) {
            $("#join-request"+id).attr('class', 'button is-small is-warning is-disabled');
            $("#join-request"+id).text('Pending');
          }
         }
     });
  }


</script>
@endpush
