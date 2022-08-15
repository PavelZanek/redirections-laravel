
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description" content="">
        <meta name="author" content="Pavel Zaněk">
        <title>Redirections for Laravel by Pavel Zaněk</title>
            
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="https://fonts.googleapis.com/css?family=Nunito:400,700,800" rel="stylesheet">
        <link rel="mask-icon" href="../safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#00aba9">
        <meta name="theme-color" content="#3b7977">

        <link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel=" stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />

        <style>
            .modal {
                transition: opacity 0.25s ease;
            }
            body.modal-active {
                overflow-x: hidden;
                overflow-y: visible !important;
            }
        </style>

    </head>
    <body class="bg-gray-200 font-sans leading-normal tracking-normal">

        <!--Nav-->
        <nav class="bg-gray-800 p-2 mt-0 fixed w-full z-10 top-0">
            <div class="container mx-auto flex flex-wrap items-center">
                <div class="flex w-full md:w-1/2 justify-center md:justify-start text-white font-extrabold">
                    <a class="text-white no-underline hover:text-white hover:no-underline" href="{{ route('redirects.index') }}">
                        <span class="text-2xl pl-2"><i class="em em-grinning"></i> {{ __('redirections-translations::general.redirectsHeadline') }}</span>
                    </a>
                </div>
                <div class="flex w-full pt-2 content-center justify-between md:w-1/2 md:justify-end">
                    <ul class="list-reset flex justify-between flex-1 md:flex-none items-center">
                        <li class="mr-3">
                            <a class="inline-block text-gray-50 no-underline hover:text-gray-200 hover:text-underline py-2 px-4" href="{{ route('redirects.index') }}">{{ __('redirections-translations::general.home') }}</a>
                        </li>
                        <li class="mr-3">
                            <a class="inline-block text-gray-50 no-underline hover:text-gray-200 hover:text-underline py-2 px-4" href="{{ route('redirects.create') }}">{{ __('redirections-translations::general.newRedirect') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!--Container-->
        <div class="container py-10 mx-auto">
            <div class="starter-template mt-5 px-5 py-5">
                <h1 class="text-4xl font-normal leading-normal mt-0 mb-2 text-gray-800">@yield('headline')</h1>
                @yield('content')
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.tailwindcss.com/?plugins=forms,typography,aspect-ratio,line-clamp"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>

        <script>
            $(document).ready(function() {
                toastr.options.timeOut = 10000;
                @if (Session::has('error'))
                    toastr.error('{{ Session::get('error') }}');
                @elseif(Session::has('success'))
                    toastr.success('{{ Session::get('success') }}');
                @endif
            });

            var openmodal = document.querySelectorAll('.modal-open')
            for (var i = 0; i < openmodal.length; i++) {
                openmodal[i].addEventListener('click', function(event){
                    event.preventDefault()
                    toggleModal()
                })
            }
            
            const overlay = document.querySelector('.modal-overlay')
            overlay.addEventListener('click', toggleModal)
            
            var closemodal = document.querySelectorAll('.modal-close')
            for (var i = 0; i < closemodal.length; i++) {
                closemodal[i].addEventListener('click', toggleModal)
            }
            
            document.onkeydown = function(evt) {
                evt = evt || window.event
                var isEscape = false
                if ("key" in evt) {
                    isEscape = (evt.key === "Escape" || evt.key === "Esc")
                } else {
                    isEscape = (evt.keyCode === 27)
                }
                if (isEscape && document.body.classList.contains('modal-active')) {
                    toggleModal()
                }
            };
            
            
            function toggleModal () {
                const body = document.querySelector('body')
                const modal = document.querySelector('.modal')
                modal.classList.toggle('opacity-0')
                modal.classList.toggle('pointer-events-none')
                body.classList.toggle('modal-active')
            }
        </script>

        @yield('footerScripts')

    </body>

</html>