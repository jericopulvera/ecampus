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
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/sweetalert2/6.4.2/sweetalert2.min.css">
        @stack('css')
           <script>
               window.Laravel = <?php echo json_encode([
                   'user' => Auth::user(),
                   'path' => request()->path(),
               ]); ?>
           </script>

    </head>
    <body>
    
        <div id="app">

            @if(Auth::check())

              <navbar></navbar>
              <conversation-list></conversation-list>
              <conversation-create></conversation-create>
              <conversation-message></conversation-message>
              
              <section class="section main">
                 
                      @yield('content')
                      
              </section>
              
            @else
          
            @yield('content')

          @endif
          
        </div>

        @stack('server-to-vue')
        
        <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
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
