@extends('templates.app')

@section('content')
    
    <div class="container body">
    <div class="columns">

        <left-panel style="order: 0;"></left-panel>
        
        <div class="column is-3" style="order: 2;">
            <div class="panel">
                <div class="panel-heading">
                    My Classes
                </div>
                @if(count($classes) === 0)
                <div class="panel-block">
                    <div class="control">
                        No Classes
                    </div>
                </div>
                @else
                @foreach($classes as $class)
                    <div class="panel-block">
                        <div class="control">
                            <a href="{{ url('/groups', $class->slug) }}"> {{ $class->slug }} </a>
                        </div>
                    </div>
                @endforeach
                @endif

            </div>

        </div>
        
        <div class="column is-6" style="order: 1;">
           
            <posts :post="{{ $post }}"></posts>
              
        </div>

        
    </div>
    </div>

@endsection

@push('server-to-vue')

@endpush

@push('css')
    <link href="/css/styles.css" rel="stylesheet">
@endpush
