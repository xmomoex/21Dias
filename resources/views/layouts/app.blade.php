<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>21 Dias</title>

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/post.css') }}" rel="stylesheet">

    <link rel="icon" href="{{ asset('images/21 Dias.png') }}" type="image/x-icon">


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->

    <script src="https://kit.fontawesome.com/0a30c633ec.js" crossorigin="anonymous"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
        <header class="header bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main>
            <div class="app-container">


                <div class="navigation-container">
                    <x-nav-link :href="route('posts.index')" :active="request()->routeIs('posts.index')">
                        <i class="fa fa-home"></i>
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('posts.create')" :active="request()->routeIs('posts.create')">
                        <i class="fa fa-edit"></i>
                        {{ __('Create Post') }}
                    </x-nav-link>
                    <x-nav-link :href="route('posts.myPosts')" :active="request()->routeIs('posts.myPosts')">
                        <i class="fa fa-file"></i>
                        {{ __('My Posts') }}
                    </x-nav-link>
                    <x-nav-link :href="route('publicprofile.show', Auth::user()->id)" :active="request()->routeIs('publicprofile.show')">
                        <i class="fa fa-user"></i>
                        {{ __('Profile') }}
                    </x-nav-link>
                    <x-nav-link :href="route('users.index', Auth::user()->id)" :active="request()->routeIs('users.index')">
                        <i class="fa fa-users"></i>
                        {{ __('Users') }}
                    </x-nav-link>
                    <x-nav-link :href="route('posts.following')" :active="request()->routeIs('posts.following')">
                        <i class="fa fa-heart"></i>
                        {{ __('Following Posts') }}
                    </x-nav-link>
                    <x-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.index')">
                        <i class="fa fa-envelope"></i>
                        {{ __('Messages') }}
                    </x-nav-link>
                    <x-nav-link :href="route('follow_requests.index')" :active="request()->routeIs('follow_requests.index')">
                        <i class="fa fa-user-plus"></i>
                        {{ __('Follow Requests') }}
                    </x-nav-link>
                    <x-nav-link :href="route('challenges.index')" :active="request()->routeIs('challenges.index')">
                        <i class="fa fa-trophy"></i>
                        {{ __('Challenges') }}
                    </x-nav-link>
                    <x-nav-link :href="route('challenges.create')" :active="request()->routeIs('challenges.create')">
                        <i class="fa fa-plus"></i>
                        {{ __('Create Challenge') }}
                    </x-nav-link>
                </div>


                <div class="navigation-movil">
                    <x-nav-link class="nav-link" :href="route('posts.index')" :active="request()->routeIs('posts.index')">
                        <i class="fa fa-home"></i>
                    </x-nav-link>
                    <x-nav-link class="nav-link" :href="route('users.index', Auth::user()->id)" :active="request()->routeIs('users.index')">
                        <i class="fa fa-users"></i>
                    </x-nav-link>
                    <x-nav-link class="nav-link" :href="route('posts.create')" :active="request()->routeIs('posts.create')">
                        <i class="fa fa-edit"></i>
                    </x-nav-link>
                    <x-nav-link class="nav-link" :href="route('messages.index')" :active="request()->routeIs('messages.index')">
                        <i class="fa fa-envelope"></i>
                    </x-nav-link>
                    <x-nav-link class="nav-link" :href="route('publicprofile.show', Auth::user()->id)" :active="request()->routeIs('publicprofile.show')">
                        <i class="fa fa-user"></i>
                    </x-nav-link>
                </div>


                <div class="centro-bg">
                    {{ $slot }}

                </div>


                <div class="derecha-bg">

                    @yield('sidebar')
                </div>




            </div>
        </main>
    </div>
</body>

</html>