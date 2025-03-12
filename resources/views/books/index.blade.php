@extends('layouts.app')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex justify-between mb-6">
                <h1 class="text-2xl font-semibold text-gray-800">My Book Library</h1>
                <a href="{{ route('books.create') }}"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Add New Book</a>
            </div>

            <div class="mb-6">
                <div class="flex space-x-2 mb-4">
                    <button
                        class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium hover:bg-indigo-200 focus:outline-none active:bg-indigo-300 filter-button"
                        data-status="all">All</button>
                    <button
                        class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium hover:bg-yellow-200 focus:outline-none filter-button"
                        data-status="TBR">TBR</button>
                    <button
                        class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium hover:bg-blue-200 focus:outline-none filter-button"
                        data-status="Reading">Reading</button>
                    <button
                        class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium hover:bg-green-200 focus:outline-none filter-button"
                        data-status="Read">Read</button>
                    <button
                        class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium hover:bg-red-200 focus:outline-none filter-button"
                        data-status="Abandoned">Abandoned</button>
                    <button
                        class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-medium hover:bg-purple-200 focus:outline-none filter-button"
                        data-status="Rereading">Rereading</button>
                </div>
            </div>

            @if($books->isEmpty())
                <div class="text-center py-8">
                    <p class="text-gray-500">Your library is empty. Start by adding your first book!</p>
                    <a href="{{ route('books.create') }}"
                        class="mt-4 inline-block px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Add Your
                        First Book</a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($books as $book)
                            <div class="book-card border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow bg-white"
                                data-status="{{ $book->status }}">
                                <div class="aspect-w-2 aspect-h-3 bg-gray-200">
                                    @if($book->cover_url)
                                        <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="object-cover h-64 w-full">
                                    @else
                                        <div class="flex items-center justify-center h-64 bg-gray-100">
                                            <span class="text-gray-400">No Cover</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-gray-800 truncate">{{ $book->title }}</h3>
                                    <p class="text-sm text-gray-600 truncate">{{ $book->author ?: 'Unknown author' }}</p>

                                    @php
                                        $statusColors = [
                                            'TBR' => 'bg-yellow-100 text-yellow-800',
                                            'Reading' => 'bg-blue-100 text-blue-800',
                                            'Read' => 'bg-green-100 text-green-800',
                                            'Abandoned' => 'bg-red-100 text-red-800',
                                            'Rereading' => 'bg-purple-100 text-purple-800',
                                        ];
                                    @endphp

                                    <div class="flex items-center mt-2">
                                        <span class="px-2 py-1 text-xs {{ $statusColors[$book->status] }} rounded-full">
                                            {{ $book->status }}
                                        </span>
                                    </div>

                                    @if($book->status == 'Reading' || $book->status == 'Rereading')
                                        <div class="mt-3">
                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                <div class="bg-indigo-600 h-2.5 rounded-full"
                                                    style="width: {{ $book->progress_percentage }}%"></div>
                                            </div>
                                            <p class="text-xs text-gray-600 mt-1">{{ $book->progress_percentage }}% complete</p>
                                        </div>
                                    @endif

                                    <div class="mt-4 flex justify-between">
                                        <a href="{{ route('books.show', $book) }}"
                                            class="text-sm text-indigo-600 hover:text-indigo-800">View</a>
                                        <a href="{{ route('books.edit', $book) }}"
                                            class="text-sm text-indigo-600 hover:text-indigo-800">Update</a>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterButtons = document.querySelectorAll('.filter-button');
            const bookCards = document.querySelectorAll('.book-card');

            filterButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const status = this.getAttribute('data-status');

                    // Update active button style
                    filterButtons.forEach(btn => btn.classList.remove('active:bg-indigo-300'));
                    this.classList.add('active:bg-indigo-300');

                    // Filter the books
                    bookCards.forEach(card => {
                        if (status === 'all' || card.getAttribute('data-status') === status) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
@endsection