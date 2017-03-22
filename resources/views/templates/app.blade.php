<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
  
        <title>AMAFV-ECAMPUS</title>
        <link rel="icon" href="/dist/img/logo.PNG" type="image/x-icon" />
        <link href="/css/bulma.css" rel="stylesheet">
        
        <link href="/admin/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="/css/sweet2.min.css">
        <style>
            html {
                overflow: auto;
            }
        </style>
        @stack('css')
           <script>
               window.Laravel = <?php echo json_encode([
                   'user' => Auth::user(),
                   'path' => request()->path(),
                   'route' => Route::currentRouteName(),
               ]); ?>
           </script>

    </head>
    <body>
    
        <div id="app">

            @if(Auth::check())

              <navbar></navbar>
              
              <section class="section main">
                 
                      @yield('content')
                      
              </section>
              
            @else
          
            @yield('content')

          @endif
          
        </div>
        
        <audio id="noty_audio">
            <source src="{{ asset('audio/notify.mp3')}}">
            <source src="{{ asset('audio/notify.ogg')}}">
        </audio>

        @stack('server-to-vue')
        
        <script src="/admin/vendors/jquery/dist/jquery.min.js"></script>
        <script src="/js/jquery.noty.packaged.min.js"></script>
        <script src="/js/back-to-top.js"></script>
        <script src="//cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
        <script src="{{ mix('js/app.js') }}"></script>
        
        @if (notify()->ready())
            <script>
                swal({
                    title: "{!! notify()->message() !!}",
                    text: "{!! notify()->option('text') !!}",
                    type: "{{ notify()->type() }}",
                    @if (notify()->option('timer'))
                        timer: {{ notify()->option('timer') }},
                        showConfirmButton: false
                    @endif
                });
            </script>
        @endif
        @stack('js')
    </body>
</html>
