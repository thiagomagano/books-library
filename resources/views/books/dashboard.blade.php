@extends('layouts.app')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h1 class="text-2xl font-semibold text-gray-800 mb-6">My Reading Dashboard</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-indigo-50 p-4 rounded-lg shadow-sm">
                    <h2 class="text-indigo-800 font-semibold text-lg mb-1">Total Books</h2>
                    <p class="text-3xl font-bold text-indigo-600">{{ $totalBooks }}</p>
                </div>

                <div class="bg-blue-50 p-4 rounded-lg shadow-sm">
                    <h2 class="text-blue-800 font-semibold text-lg mb-1">Currently Reading</h2>
                    <p class="text-3xl font-bold text-blue-600">{{ $readingCount }}</p>
                </div>

                <div class="bg-yellow-50 p-4 rounded-lg shadow-sm">
                    <h2 class="text-yellow-800 font-semibold text-lg mb-1">To Be Read</h2>
                    <p class="text-3xl font-bold text-yellow-600">{{ $tbrCount }}</p>
                </div>

                <div class="bg-green-50 p-4 rounded-lg shadow-sm">
                    <h2 class="text-green-800 font-semibold text-lg mb-1">Completed</h2>
                    <p class="text-3xl font-bold text-green-600">{{ $readCount }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white p-4 rounded-lg shadow-sm border">
                    <h2 class="text-gray-800 font-semibold text-lg mb-4">Reading Progress</h2>

                    @if($currentlyReading->isEmpty())
                        <p class="text-gray-500">You're not currently reading any books.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($currentlyReading as $book)
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700 truncate">{{ $book->title }}</span>
                                        <span class="text-sm text-gray-600">{{ $book->progress_percentage }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-indigo-600 h-2.5 rounded-full"
                                            style="width: {{ $book->progress_percentage }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="bg-white p-4 rounded-lg shadow-sm border">
                    <h2 class="text-gray-800 font-semibold text-lg mb-4">Recently Added</h2>

                    @if($recentlyAdded->isEmpty())
                        <p class="text-gray-500">Your library is empty. Start by adding your first book!</p>
                    @else
                        <div class="divide-y">
                            @foreach($recentlyAdded as $book)
                                <div class="py-3 flex items-center">
                                    <div class="flex-shrink-0 h-12 w-8 bg-gray-200 rounded overflow-hidden mr-3">
                                        @if($book->cover_url)
                                            <img src="{{ $book->cover_url }}" alt="{{ $book->title }}"
                                                class="h-full w-full object-cover">
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-medium text-gray-800 truncate">{{ $book->title }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ $book->author ?: 'Unknown author' }}</p>
                                    </div>
                                    <div>
                                        <a href="{{ route('books.show', $book) }}"
                                            class="text-indigo-600 hover:text-indigo-800 text-sm">View</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection