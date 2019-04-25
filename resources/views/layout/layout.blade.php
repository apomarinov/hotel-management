<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', 'Hotel Manager')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    </head>
    <body>
        <div id="app" class="hero is-info is-fullheight">
            <navigation :tab="'{{ Request::segment(1) ?? '' }}'" inline-template>
                <div class="hero-head" >
                    <nav class="navbar">
                        <div class="container">
                            <div class="navbar-brand">
                                <a class="navbar-item" href="/">
                                    <i class="fas fa-h-square fa-2x"></i>
                                </a>
                                <span class="navbar-burger burger" data-target="navbarMenuHeroA" onclick="document.querySelector('.navbar-menu').classList.toggle('is-active'); document.querySelector('.navbar-burger').classList.toggle('is-active');">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                            </div>
                            <div id="navbarMenuHeroA" class="navbar-menu">
                                <div class="navbar-end">
                                    <a v-for="t in tabs" :href="t" :class="tabClasses(t)">
                                        @{{ t | capitalize }}
                                    </a>
                                    <span class="navbar-item">
                                      <a class="button is-info is-inverted" href="/reservations/create">
                                        <span class="icon">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                        <span>Reservation</span>
                                      </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
            </navigation>

            <!-- Hero content: will be in the middle -->
            <div class="hero-body">
                <div class="container has-text-centered">
                    @yield('content')
                </div>
            </div>
        </div>

        <script src="{{ mix('js/manifest.js') }}"></script>
        <script src="{{ mix('js/vendor.js') }}"></script>
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
