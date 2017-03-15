@extends('admin.templates.app')

@section('content')
<div class="container">
    <!-- CURRENT ACADEMIC TERM ACADEMIC TERM -->
    <div class="col-md-4 col-sm-12 col-xs-12">
        
        <div class="x_panel">
            <form action=" {{ route('academic-term.update', $term->id) }} " method="POST" role="form">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <legend>Update This Term Start and End Month</legend>
                <div class="form-group">
                    <input type="date" name="start" class="form-control" value="{{ $term->start->toDateString()}}" required="required" title="">
                </div>
                <div class="form-group">
                    <input type="date" name="end" class="form-control" value="{{ $term->end->toDateString()}}" required="required" title="">
                </div>
                
                <button type="submit" class="btn btn-default">Save Changes</button>
                <a class="btn btn-default" href="{{ route('academic-term.index') }}" role="button">Go Back</a>
            </form>
        </div>
    </div>
</div>

@endsection
