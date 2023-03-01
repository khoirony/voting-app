<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laracast Voting</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Open+Sans:400,500,600&display=swap" rel="stylesheet" />

        <livewire:styles />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 text-sm bg-gray-background">
        <header class="flex flex-col md:flex-row items-center justify-between px-8 py-4">
            <a href="/"><img src="{{ asset('img/logo.svg') }}" alt="logo"></a>
            <div class="flex items-center mt-2 md:mt-0">
                @if (Route::has('login'))
                    <div class="px-6 py-4">
                        @auth
                            <div class="flex items-center space-x-4">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Log out') }}
                                    </a>
                                </form>

                                <livewire:comment-notifications />
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
                <a href="#">
                    <img src="https://www.gravatar.com/avatar/000?d=mp" alt="alt" class="w-10 h-10 rounded-full">
                </a>
            </div>
        </header>
        
        <main class="container mx-auto flex max-w-custom flex-col md:flex-row" style="max-width:1000px">
            <div class="md:w-70 w-[90%] mx-auto md:mx-0 md:mr-5">
                <div class="border-2 md:sticky md:top-8 border-blue bg-white rounded-xl mt-16">

                    <div class="text-center px-6 py-2 pt-6">
                        <h3 class="font-semibold text-base">Add an idea</h3>
                        @auth
                        <p class="text-xs mt-4">Let us know what you would like and we'll take a look over!</p>
                        @else
                        <p class="text-xs mt-4">Please login to create an idea!</p>
                        @endauth
                    </div>

                    @auth
                    <livewire:create-idea />
                    @else
                    <div class="my-6 text-center">
                        <a href="{{ route('login') }}" class="inline-block justify-center w-1/2 text-xs text-white bg-blue font-semibold rounded-xl border border-blue hover:bg-blue-hover transition duration-150 ease-in px-6 py-3">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="inline-block justify-center w-1/2 text-xs bg-gray-200 font-semibold rounded-xl border border-gray-200 hover:border-gray-400 transition duration-150 ease-in px-6 py-3 mt-3">
                            Sign Up
                        </a>
                    </div>
                    @endauth
                </div>
            </div>
            <div class="w-full px-2 md:px-0 md:w-175">
                <livewire:status-filters/>

                <div class="mt-8">
                    {{ $slot }}
                </div>
            </div>
            {{-- <div class="w-24"></div> --}}
        </main>

        @if (session('success_message'))
            <x-notification-success
                :redirect="true"
                message-to-display="{{ (session('success_message')) }}"
            />
        @endif
        
        <livewire:scripts />
    </body>
</html>
