@extends('admin.templates.app')

@section('content')

    <div class="container">
        <div class="title_left">
            <h3>Academic Terms</h3>
        </div>

            <div class="panel">
                <div class="panel-body">
                    <ul class="list-group">
                        @foreach ($academic_terms as $term)
                            <li class="list-group-item">
                                {{ $term->semester }} Trimester - {{ $term->year }}
                                 
                                 <span class="pull-right"><a class="btn btn-info btn-xs" href="{{ route('academic-term.edit', $term->id) }}" role="button">Edit</a></span>
                            </li>
                        @endforeach
                    </ul>
                </div>

          
            
        </div>
    </div>
   

   
@endsection
