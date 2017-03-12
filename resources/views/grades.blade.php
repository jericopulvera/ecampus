@extends('templates.app')

@section('content')

    <div class="container body">
    @if(count($records) === 0)
      <div class="title">Student's that has Failed or Incomplete grades won't appear till the end of this term.</div>
    @else
    <table class="table">
      <thead>
        <tr>
          <th><abbr title="USN">USN</th>
          <th><abbr title="NAME">NAME</abbr></th>
          <th><abbr title="COURSE">COURSE</abbr></th>
          <th><abbr title="SUBJECT-SECTION">SUBJECT-SECTION</abbr></th>
          <th><abbr title="STATUS">STATUS</abbr></th>
        </tr>
      </thead>
      <tbody>
      @foreach($records as $record)
        <tr>
          <td>{{ $record->user()->first()->usn }}</td>
          <td>{{ $record->user()->first()->name }}</td>
          <td>{{ $record->user()->first()->course }}</td>
          <td>{{ $record->subject }}</td>
          <td>{{ $record->status }}</td>
        </tr>
      @endforeach
      </tbody>
    </table>
    @endif
    
    </div>
    
@endsection

@push('server-to-vue')

@endpush
