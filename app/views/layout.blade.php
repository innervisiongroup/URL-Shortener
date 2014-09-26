<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>URL Shortener</title>
    <link rel="icon" type="image/png" href="http://assets.innervisiongroup.com/img/fav/icon.png">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    @if (Session::has('flash_message'))
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get('flash_message') }}
        </div>
    @endif

    <div class="container">
        @yield('content')
    </div>

    <footer>
        <nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
            <div class="container">
                <div class="text-center">Created by {{ link_to('http://innervisionweb.com', 'Inner Vision Web', ['target'=>'_blank']) }}</div>
                <div class="text-center">Build with {{ link_to('http://laravel.com', 'Laravel Framework', ['target'=>'_blank']) }} and forked from {{ link_to('https://github.com/laracasts/URL-Shortener', 'Laracasts', ['target'=>'_blank']) }}</div>
            </div>
        </nav>
    </footer>

    <!-- Please don't use massive JS files for minor functionality. This is okay for the demo, though. -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
</body>
</html>