@extends('layouts.app')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex justify-between mb-6">
                <h1 class="text-2xl font-semibold text-gray-800">Book Details</h1>
                <div>
                    <a href="{{ route('books.edit', $book) }}"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Update</a>
                    <a href="{{ route('books.index') }}"
                        class="ml-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Back to Library</a>
                </div>
            </div>

            <div class="flex flex-col md:flex-row">
                <div class="md:w-1/3 mb-6 md:mb-0 md:pr-6">
                    @if($book->cover_url)
                        <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full rounded-lg shadow-md">
                    @else
                        <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                            <span class="text-gray-400">No Cover Available</span>
                        </div>
                    @endif

                    @php
                        $statusColors = [
                            'TBR' => 'bg-yellow-100 text-yellow-800',
                            'Reading' => 'bg-blue-100 text-blue-800',
                            'Read' => 'bg-green-100 text-green-800',
                            'Abandoned' => 'bg-red-100 text-red-800',
                            'Rereading' => 'bg-purple-100 text-purple-800',
                        ];
                    @endphp

                    <div class="mt-4">
                        <span class="px-3 py-1 {{ $statusColors[$book->status] }} rounded-full text-sm font-medium">
                            {{ $book->status }}
                        </span>
                    </div>

                    @if($book->status == 'Reading' || $book->status == 'Rereading')
                        <div class="mt-4">
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Reading Progress</h3>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $book->progress_percentage }}%">
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">{{ $book->progress_percentage }}% complete</p>
                        </div>

                        <form action="{{ route('books.update', $book) }}" method="POST" class="mt-4">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="title" value="{{ $book->title }}">
                            <input type="hidden" name="author" value="{{ $book->author }}">
                            <input type="hidden" name="status" value="{{ $book->status }}">

                            <div class="mb-4">
                                <label for="progress_percentage" class="block text-gray-700 text-sm font-medium mb-2">Update
                                    Progress</label>
                                <input type="number" name="progress_percentage" id="progress_percentage" min="0" max="100"
                                    value="{{ $book->progress_percentage }}"
                                    class="shadow-sm appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-20">
                                <button type="submit"
                                    class="ml-2 px-3 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">
                                    Update
                                </button>
                            </div>
                        </form>
                    @endif

                    <div class="mt-6">
                        <form action="{{ route('books.destroy', $book) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to remove this book from your library?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                Remove from library
                            </button>
                        </form>
                    </div>
                </div>

                <div class="md:w-2/3">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">{{ $book->title }}</h2>
                    <p class="text-xl text-gray-600 mb-4">{{ $book->author ?: 'Unknown author' }}</p>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        @if($book->publisher)
                            <div>
                                <h3 class="text-sm font-medium text-gray-700">Publisher</h3>
                                <p class="text-gray-800">{{ $book->publisher }}</p>
                            </div>
                        @endif

                        @if($book->published_date)
                            <div>
                                <h3 class="text-sm font-medium text-gray-700">Published</h3>
                                <p class="text-gray-800">{{ $book->published_date->format('F Y') }}</p>
                            </div>
                        @endif

                        @if($book->page_count)
                            <div>
                                <h3 class="text-sm font-medium text-gray-700">Pages</h3>
                                <p class="text-gray-800">{{ $book->page_count }}</p>
                            </div>
                        @endif

                        @if($book->isbn)
                            <div>
                                <h3 class="text-sm font-medium text-gray-700">ISBN</h3>
                                <p class="text-gray-800">{{ $book->isbn }}</p>
                            </div>
                        @endif
                    </div>

                    @if($book->description)
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-800 mb-2">Description</h3>
                            <div class="text-gray-700 prose max-w-none">
                                {!! nl2br(e($book->description)) !!}
                            </div>
                        </div>
                    @endif

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-800 mb-2">Reading History</h3>
                        <div class="space-y-2">
                            @if($book->started_at)
                                <p class="text-gray-700">
                                    <span class="font-medium">Started:</span> {{ $book->started_at->format('F j, Y') }}
                                </p>
                            @endif

                            @if($book->finished_at)
                                <p class="text-gray-700">
                                    <span class="font-medium">Finished:</span> {{ $book->finished_at->format('F j, Y') }}
                                </p>
                            @endif

                            @if(!$book->started_at && !$book->finished_at)
                                <p class="text-gray-500 italic">No reading history available</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection