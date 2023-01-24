<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{--مشان النجمات تشتغل--}}
    <meta name="csrf-token" content="{{csrf_token()}}"/>

    {{--توصلية العنوان--}}
    <title>@yield('title')</title>

    {{--هاد الكود كتبناه بدل يلي تحتو لانو ما اشتغل--}}
    @vite(['resources/css/app.css'])
    {{--<link rel="stylesheet" href="{{asset('css/app.css')}}"--}}

    {{--Bootstrap--}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    {{--taoster.css هاد مشان تنسيق الخطا يلي ممكن يظهر اثناء التقييم--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.css" integrity="sha512-oe8OpYjBaDWPt2VmSFR+qYOdnTjeV9QPLJUeqZyprDEQvQLJ9C5PCFclxwNuvb/GQgQngdCXzKSFltuHD3eCxA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{--Font Nuito--}}
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">


    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f0f0f0;
        }


        .bg-cart {
            background-color: #ffc107;
            color: #fff
        }

        .score {
            display: block;
            font-size: 16px;
            position: relative;
            overflow: hidden;
        }
        .score-wrap {
            display: inline-block;
            position: relative;
            height: 19px;
        }
        .score .stars-active {
            color: #FFCA00;
            position: relative;
            z-index: 10;
            display: block;
            overflow: hidden;
            white-space: nowrap;
        }
        .score .stars-inactive {
            color: lightgrey;
            position: absolute;
            top: 0;
            left: 0;
        }

        .rating {
            overflow: hidden;
            display: inline-block;
            position: relative;
            font-size: 20px;
        }
        .rating-star {
            padding: 0 5px;
            margin: 0;
            cursor: pointer;
            display: block;
            float: left;
        }
        .rating-star:after {
            position: relative;
            font-family: "Font Awesome 5 Free";
            content: '\f005';
            color: lightgrey;
        }
        .rating-star.checked ~ .rating-star:after,
        .rating-star.checked:after {
            content: '\f005';
            color: #FFCA00;
        }
        .rating:hover .rating-star:after {
            content: '\f005';
            color: lightgrey;
        }
        .rating-star:hover ~ .rating-star:after,
        .rating .rating-star:hover:after {
            content: '\f005';
            color: #FFCA00;
        }
    </style>
    {{--توصلية الراس مشان اذا بدنا نعدل بالتصميم--}}
    @yield('head')

</head>
<body>

<div>
    {{--Start NavBar --}}
    <nav class="navbar navbar-expand-lg bg-white">
        <div class="container-fluid">

            {{--Start Brand--}}
            <a class="navbar-brand" href="{{url('/')}}">
                <img src="/logo.png" alt="" width="100" height="100">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            {{--End Brand--}}

            {{--Start Middle Items--}}
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">

                        <a href="{{route('gallery.categories.index')}}" class="nav-link link-secondary">
                            <i class="fas fa-list"></i> Categorise
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('gallery.publishers.index')}}" class="nav-link link-secondary">
                            <i class="fas fa-table"></i> Publishers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('gallery.authors.index')}}" class="nav-link link-secondary">
                            <i class="fas fa-pen"></i> Authors
                        </a>
                    </li>
                    @auth()
                    <li class="nav-item">
                        <a href="{{route('my.product')}}" class="nav-link link-secondary">
                            <i class="fas fa-basket-shopping"></i> My Purchases
                        </a>
                    </li>
                    @endauth
                    @auth
                        <li class="nav-item">
                            <a class="nav-link link-secondary" href="{{route('cart.view')}}">
                                Cart
                                <i class="fas fa-shopping-cart"></i>
                                @if(Auth::user()->booksInCart()->count() > 0)
                                    <span class="badge bg-secondary">{{ Auth::user()->booksInCart()->count() }}</span>
                                @else
                                    <span class="badge bg-secondary">0</span>
                                @endif

                            </a>
                        </li>
                    @endauth
                </ul>
                {{--End Middle Items--}}

                {{--Start Profile Dropdown--}}
                {{--في حال كان غير مسجل بحساب تظهر هذه القائمة--}}
                <ul class="navbar-nav my-auto">
                    @guest
                        <li class="nav-item">
                            <a href="{{route('login')}}" class="nav-link link-secondary">{{__('login')}}</a>
                        </li>
                        @if(Route::has('register'))
                            <li class="nav-item">
                                <a href="{{route('register')}}" class="nav-link link-secondary">{{__('Sign up')}}</a>
                            </li>
                        @endif

                    {{--في حال كان مسجل بحساب تظهر هذه القائمة--}}
                    @else
                        <li class="nav-item dropdown justify-content-right">
                            <a href="#" id="navbarDropdown" data-bs-toggle="dropdown"  class="nav-link link-secondary">
                                <img class="h-8 w-8 rounded-full object-cover" src="{{Auth::user()->profile_photo_url}}" alt="{{Auth::user()->name}}">
                            </a>

                            <div class="dropdown-menu dropdown-menu-end text-right px-2 mt-2 ">

                                <div class="pt-4 pb-1 border-t border-gray-200">
                                <div class="flex items-center px-5 border-b border-gray-200">
                                    <div>
                                        <div class="font-medium  mb-4">{{ Auth::user()->name }}</div>
                                    </div>
                                </div>

                                <div class="mt-2 space-y-1">
                                    @can('update-books')
                                        <x-jet-responsive-nav-link href="{{route('admin.index')}}" style="text-decoration: none" :active="request()->routeIs('profile.show')" >
                                            {{ __('Control Panel') }}
                                        </x-jet-responsive-nav-link>
                                    @endcan
                                    <!-- Account Management -->
                                    <x-jet-responsive-nav-link href="{{ route('profile.show') }}" style="text-decoration: none" :active="request()->routeIs('profile.show')" >
                                        {{ __('Profile') }}
                                    </x-jet-responsive-nav-link>

                                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                        <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                                            {{ __('API Tokens') }}
                                        </x-jet-responsive-nav-link>
                                    @endif

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}" x-data>
                                        @csrf

                                        <x-jet-responsive-nav-link href="{{ route('logout') }}" style="text-decoration: none"
                                            onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </x-jet-responsive-nav-link>
                                    </form>

                                    <!-- Team Management -->
                                    @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                                        <div class="border-t border-gray-200"></div>

                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Manage Team') }}
                                        </div>

                                        <!-- Team Settings -->
                                        <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                                            {{ __('Team Settings') }}
                                        </x-jet-responsive-nav-link>

                                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                            <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                                                {{ __('Create New Team') }}
                                            </x-jet-responsive-nav-link>
                                        @endcan

                                        <div class="border-t border-gray-200"></div>

                                        <!-- Team Switcher -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Switch Teams') }}
                                        </div>

                                        @foreach (Auth::user()->allTeams() as $team)
                                            <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link" />
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            </div>
                        </li>
                    @endguest
                </ul>
            {{--End Profile Dropdown--}}

            </div>
        </div>
    </nav>
    {{--End NavBar --}}

    <main class="py-4">
        {{--توصيلة المحتوى--}}
        @yield('content')
    </main>

</div>

    {{--Bootstrap JS--}}
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    {{--Font Awosme--}}
    <script src="https://kit.fontawesome.com/9ee8d37083.js" crossorigin="anonymous"></script>
    {{--توصلة الجافا مشان اذا بدنا نكتب اكود سكريبت اضافية--}}
    {{--  مشان النجمات ajax مكتبة   --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    {{--taoster.min.js هاد مشان الخطا يلي ممكن يظهر اثناء التقييم--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @yield('script')
</body>
</html>
