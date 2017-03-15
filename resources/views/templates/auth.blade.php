<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>AMAFV-ECAMPUS</title>
        <link rel="icon" href="/dist/img/logo.png" type="image/x-icon" />
        <link href="/css/bulma.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.3.0/sweetalert2.min.css">

    </head>

    <body>
    
        <div id="app">
            <section class="hero is-fullheight is-dark is-bold">

                <div class="hero-body">

                    <div class="container">


                         @yield('content')


                    </div>

                </div>

            </section>

        </div>
        
        @stack('server-to-vue')
        <script src="{{ mix('js/app.js') }}"></script>
        
    </body>
    
</html>
