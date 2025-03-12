@extends('layouts.app')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex justify-between mb-6">
                <h1 class="text-2xl font-semibold text-gray-800">Edit Book</h1>
                <a href="{{ route('books.show', $book) }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Back to Details</a>
            </div>

            <form action="{{ route('books.update', $book) }}" method="POST" class="max-w-2xl">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="title" class="block text-gray-700 text-sm font-medium mb-2">Title <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}" required
                        class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="author" class="block text-gray-700 text-sm font-medium mb-2">Author</label>
                    <input type="text" name="author" id="author" value="{{ old('author', $book->author) }}"
                        class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-gray-700 text-sm font-medium mb-2">Reading Status</label>
                    <select name="status" id="status"
                        class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="TBR" {{ old('status', $book->status) == 'TBR' ? 'selected' : '' }}>To Be Read</option>
                        <option value="Reading" {{ old('status', $book->status) == 'Reading' ? 'selected' : '' }}>Currently
                            Reading</option>
                        <option value="Read" {{ old('status', $book->status) == 'Read' ? 'selected' : '' }}>Finished Reading
                        </option>
                        <option value="Abandoned" {{ old('status', $book->status) == 'Abandoned' ? 'selected' : '' }}>
                            Abandoned</option>
                        <option value="Rereading" {{ old('status', $book->status) == 'Rereading' ? 'selected' : '' }}>
                            Rereading</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="progress_percentage" class="block text-gray-700 text-sm font-medium mb-2">Reading Progress
                        (%)</label>
                    <input type="number" name="progress_percentage" id="progress_percentage" min="0" max="100"
                        value="{{ old('progress_percentage', $book->progress_percentage) }}"
                        class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label for="isbn" class="block text-gray-700 text-sm font-medium mb-2">ISBN</label>
                    <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $book->isbn) }}"
                        class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-100"
                        readonly>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 text-sm font-medium mb-2">Description</label>
                    <textarea name="description" id="description" rows="5"
                        class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description', $book->description) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="publisher" class="block text-gray-700 text-sm font-medium mb-2">Publisher</label>
                        <input type="text" name="publisher" id="publisher" value="{{ old('publisher', $book->publisher) }}"
                            class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label for="page_count" class="block text-gray-700 text-sm font-medium mb-2">Page Count</label>
                        <input type="number" name="page_count" id="page_count"
                            value="{{ old('page_count', $book->page_count) }}"
                            class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>

                <div class="mt-6 flex">
                    <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Update Book
                    </button>
                    <a href="{{ route('books.show', $book) }}"
                        class="ml-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection