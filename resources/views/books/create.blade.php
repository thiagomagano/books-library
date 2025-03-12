@extends('layouts.app')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h1 class="text-2xl font-semibold text-gray-800 mb-6">Add New Book</h1>

            <form action="{{ route('books.store') }}" method="POST" class="max-w-2xl">
                @csrf

                <div class="mb-4">
                    <label for="title" class="block text-gray-700 text-sm font-medium mb-2">Title <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="author" class="block text-gray-700 text-sm font-medium mb-2">Author</label>
                    <input type="text" name="author" id="author" value="{{ old('author') }}"
                        class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label for="isbn" class="block text-gray-700 text-sm font-medium mb-2">ISBN (to fetch metadata)</label>
                    <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}"
                        class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="e.g., 9780141439518">
                    <p class="text-sm text-gray-500 mt-1">Enter an ISBN to automatically fetch book details</p>
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-gray-700 text-sm font-medium mb-2">Reading Status</label>
                    <select name="status" id="status"
                        class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="TBR" {{ old('status') == 'TBR' ? 'selected' : '' }}>To Be Read</option>
                        <option value="Reading" {{ old('status') == 'Reading' ? 'selected' : '' }}>Currently Reading</option>
                        <option value="Read" {{ old('status') == 'Read' ? 'selected' : '' }}>Finished Reading</option>
                        <option value="Abandoned" {{ old('status') == 'Abandoned' ? 'selected' : '' }}>Abandoned</option>
                        <option value="Rereading" {{ old('status') == 'Rereading' ? 'selected' : '' }}>Rereading</option>
                    </select>
                </div>

                <div class="mt-6 flex">
                    <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Add Book
                    </button>
                    <a href="{{ route('books.index') }}"
                        class="ml-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection