@extends('admin.templates.app')

@section('content')
<div class="title_left">
    <h3>Academy Settings</h3>
</div>
<div class="row">
    <!-- DISPLAY CURRENT ACADEMIC TERM -->
    <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="x_panel">
            <h2>Current Settings</h2>
            
            Semester: {{$setting->term->semester}} <br>
            Year: {{$setting->term->year}} <br>
            Start Month: {{$setting->term->start->toFormattedDateString() }} <br>
            End Month: {{$setting->term->end->toFormattedDateString() }}
            
        </div>
    </div>
</div>
<!-- DISPLAY LIST OF ACADEMIC TERM IN RADIO BUTTON WITH EDIT OPTION AT THE RIGHT SIDE  -->
<div class="row">
    <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="x_panel">
            <form action="/admin/settings" method="POST" role="form">
                {{ csrf_field() }}
                @foreach ($academic_terms as $term)
                <div class="form-group">
                    <div class="row">
                        <div class="radio">
                            <label>
                                <input type="radio" name="term_id" id="input" value="{{ $term->id }}" {{ $term->id === $setting->term->id ? 'checked' : '' }}>
                                {{ $term->semester }} Trimester - School Year {{ $term->year }}
                            </label>
                        </div>
                    </div>
                </div>
                @endforeach
                
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection

