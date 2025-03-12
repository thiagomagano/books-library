<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Book Library') }}</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <nav class="bg-indigo-600 text-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ route('books.index') }}" class="text-xl font-bold">My Book Library</a>
                        </div>
                        <div class="ml-6 flex space-x-4 items-center">
                            <a href="{{ route('books.index') }}"
                                class="px-3 py-2 rounded-md text-sm font-medium hover:bg-indigo-500">My Books</a>
                            <a href="{{ route('books.create') }}"
                                class="px-3 py-2 rounded-md text-sm font-medium hover:bg-indigo-500">Add Book</a>
                            <a href="{{ route('dashboard') }}"
                                class="px-3 py-2 rounded-md text-sm font-medium hover:bg-indigo-500">Dashboard</a>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <form action="{{ route('books.search') }}" method="GET" class="flex">
                            <input type="text" name="query" placeholder="Search books..."
                                class="rounded-l-md text-gray-800 px-4 py-2 text-sm focus:outline-none">
                            <button type="submit"
                                class="bg-indigo-700 rounded-r-md px-4 hover:bg-indigo-800">Search</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>