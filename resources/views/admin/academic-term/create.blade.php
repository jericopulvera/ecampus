 @extends('admin.templates.app')

 @section('content')
 <!-- CREATE ACADEMIC TERM -->
<div class="row">
    <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="x_panel">
            <form action=" {{ route('academic-term.store') }} " method="POST" role="form">
                {{ csrf_field() }}
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
                        <option value="2019-2020">2020-2021</option>
                        <option value="2019-2020">2021-2022</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="date" name="start" class="form-control" required="required" title="">
                </div>
                <div class="form-group">
                    <input type="date" name="end" class="form-control" required="required" title="">
                </div>
                
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
