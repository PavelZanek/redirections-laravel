<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="Pavel Zaněk">
        <title>Redirections for Laravel by Pavel Zaněk</title>
            
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
            <a class="navbar-brand" href="{{ route('redirects.index') }}">{{ __('redirections-translations::general.redirectsHeadline') }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsRedirectsDefault" aria-controls="navbarsRedirectsDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsRedirectsDefault">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item {{ request()->routeIs('redirects.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('redirects.index') }}">{{ __('redirections-translations::general.home') }} <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('redirects.create') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('redirects.create') }}">{{ __('redirections-translations::general.newRedirect') }}</a>
                    </li>
                </ul>
            </div>
        </nav>

        <main role="main">

        <div class="starter-template mt-5 px-5 py-5">
            <h1>@yield('headline')</h1>
            @yield('content')
        </div>

        </main><!-- /.container -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        @yield('footerScripts')
    </body>
</html>