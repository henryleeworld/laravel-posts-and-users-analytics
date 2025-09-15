<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        @vite(['resources/css/app.css'])
    </head>
    <body class="h-full">
        <div class="min-h-full">
            <nav class="bg-white shadow-sm border-b border-gray-200">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between">
                        <div class="flex">
                            <div class="flex flex-shrink-0 items-center">
                                <h2 class="text-xl font-bold text-gray-900">
                                    <a href="{{ route('admin.dashboard') }}">{{ config('app.name', 'Laravel') }}</a>
                                </h2>
                            </div>
                            <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                                <a href="{{ route('admin.dashboard') }}" 
                                   class="@if(request()->routeIs('admin.dashboard')) border-indigo-500 text-gray-900 @else border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 @endif inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium">
                                    {{ __('Dashboard') }}
                                </a>
                                <a href="{{ route('admin.analytics.index') }}" 
                                   class="@if(request()->routeIs('admin.analytics.*')) border-indigo-500 text-gray-900 @else border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 @endif inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium">
                                    {{ __('Analytics') }}
                                </a>
                                <a href="{{ route('admin.users.index') }}" 
                                   class="@if(request()->routeIs('admin.users.*')) border-indigo-500 text-gray-900 @else border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 @endif inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium">
                                    {{ __('Users') }}
                                </a>
                                <a href="{{ route('admin.posts.index') }}" 
                                   class="@if(request()->routeIs('admin.posts.*')) border-indigo-500 text-gray-900 @else border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 @endif inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium">
                                    {{ __('Posts') }}
                                </a>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="text-sm text-gray-700">
								    {{ __('Welcome, :user_name', ['user_name' => auth()->user()->name] ) }}
                                </span>
                            </div>
                            <div class="ml-4">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">
									    {{ __('Logout') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            @if(isset($header))
            <header class="bg-white shadow">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
            @endif
            <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                {{ $slot }}
            </main>
        </div>
        @vite(['resources/js/app.js'])
    </body>
</html>
