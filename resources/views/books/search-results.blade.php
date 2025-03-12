@extends('layouts.app')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex justify-between mb-6">
                <h1 class="text-2xl font-semibold text-gray-800">Search Results</h1>
                <a href="{{ route('books.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Back to Library</a>
            </div>

            @if(empty($results))
                <div class="text-center py-8">
                    <p class="text-gray-500">No books found. Try a different search term.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($results as $book)
                        <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow bg-white">
                            <div class="aspect-w-2 aspect-h-3 bg-gray-200">
                                @if(isset($book['volumeInfo']['imageLinks']['thumbnail']))
                                    <img src="{{ $book['volumeInfo']['imageLinks']['thumbnail'] }}"
                                        alt="{{ $book['volumeInfo']['title'] }}" class="object-cover h-64 w-full">
                                @else
                                    <div class="flex items-center justify-center h-64 bg-gray-100">
                                        <span class="text-gray-400">No Cover</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800 truncate">{{ $book['volumeInfo']['title'] }}</h3>
                                @if(isset($book['volumeInfo']['authors']))
                                    <p class="text-sm text-gray-600 truncate">{{ implode(', ', $book['volumeInfo']['authors']) }}</p>
                                @else
                                    <p class="text-sm text-gray-600 truncate">Unknown author</p>
                                @endif

                                @if(isset($book['volumeInfo']['publishedDate']))
                                    <p class="text-xs text-gray-500 mt-2">Published: {{ $book['volumeInfo']['publishedDate'] }}</p>
                                @endif

                                <form action="{{ route('books.store') }}" method="POST" class="mt-4">
                                    @csrf
                                    <input type="hidden" name="title" value="{{ $book['volumeInfo']['title'] }}">

                                    @if(isset($book['volumeInfo']['authors']))
                                        <input type="hidden" name="author" value="{{ implode(', ', $book['volumeInfo']['authors']) }}">
                                    @endif

                                    @if(isset($book['volumeInfo']['industryIdentifiers']))
                                        @foreach($book['volumeInfo']['industryIdentifiers'] as $identifier)
                                            @if($identifier['type'] === 'ISBN_13')
                                                <input type="hidden" name="isbn" value="{{ $identifier['identifier'] }}">
                                            @endif
                                        @endforeach
                                    @endif

                                    @if(isset($book['volumeInfo']['description']))
                                        <input type="hidden" name="description" value="{{ $book['volumeInfo']['description'] }}">
                                    @endif

                                    @if(isset($book['volumeInfo']['imageLinks']['thumbnail']))
                                        <input type="hidden" name="cover_url"
                                            value="{{ $book['volumeInfo']['imageLinks']['thumbnail'] }}">
                                    @endif

                                    @if(isset($book['volumeInfo']['publisher']))
                                        <input type="hidden" name="publisher" value="{{ $book['volumeInfo']['publisher'] }}">
                                    @endif

                                    @if(isset($book['volumeInfo']['publishedDate']))
                                        <input type="hidden" name="published_date" value="{{ $book['volumeInfo']['publishedDate'] }}">
                                    @endif

                                    @if(isset($book['volumeInfo']['pageCount']))
                                        <input type="hidden" name="page_count" value="{{ $book['volumeInfo']['pageCount'] }}">
                                    @endif

                                    <input type="hidden" name="status" value="TBR">
                                    <input type="hidden" name="progress_percentage" value="0">

                                    <button type="submit"
                                        class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm">
                                        Add to Library
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection