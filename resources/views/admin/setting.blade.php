@extends('admin.templates.app')

@section('content')
<div class="title_left">
    <h3>Academy Settings</h3>
</div>
    <div class="row">
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

    <div class="row">
        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="x_panel">
                <form action="" method="POST" role="form">
                    <legend>Create New Term</legend>
                    
                    <div class="form-group">
                        <div class="radio">
                            <label>
                                <input type="radio" name="semester" id="input" value="1st">
                                1st
                            </label>
                            <label>
                                <input type="radio" name="semester" id="input" value="2nd">
                                2nd
                            </label>
                            <label>
                                <input type="radio" name="semester" id="input" value="3rd">
                                3rd
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <select name="year" id="input" class="form-control" required="required">
                            <option value="2017-2018">2017-2018</option>
                            <option value="2018-2019">2018-2019</option>
                            <option value="2018-2019">2018-2019</option>
                            <option value="2019-2020">2019-2020</option>
                        </select>
                    </div>

                    <div class="form-group">
                        
                    </div>
                    
                
                </form>
            </div>
        </div>
    </div>
   
    
@endsection

@push('admin-css')
    <link href="/admin/vendors/nprogress/nprogress.css" rel="stylesheet">
@endpush

@push('admin-js')
    <script src="/admin/vendors/echarts/dist/echarts.min.js"></script>
@endpush
