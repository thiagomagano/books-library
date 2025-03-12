<?php

namespace App\Http\Controllers;


use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:20',
        ]);

        // If ISBN is provided, try to fetch metadata
        if (!empty($validated['isbn'])) {
            $bookData = $this->fetchBookMetadata($validated['isbn']);
            if ($bookData) {
                $validated = array_merge($validated, $bookData);
            }
        }

        Book::create($validated);
        return redirect()->route('books.index')->with('success', 'Book added successfully!');
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'status' => 'required|in:TBR,Reading,Read,Abandoned,Rereading',
            'progress_percentage' => 'required|integer|min:0|max:100',
        ]);

        // Handle status changes and timestamps
        if ($book->status != $validated['status']) {
            if ($validated['status'] == 'Reading' && !$book->started_at) {
                $validated['started_at'] = now();
            } elseif ($validated['status'] == 'Read') {
                $validated['finished_at'] = now();
                $validated['progress_percentage'] = 100;
            }
        }

        $book->update($validated);
        return redirect()->route('books.index')->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book removed from library!');
    }

    private function fetchBookMetadata($isbn)
    {
        // Using Google Books API as an example
        try {
            $response = Http::get("https://www.googleapis.com/books/v1/volumes", [
                'q' => "isbn:{$isbn}"
            ]);

            if ($response->successful() && isset($response['items'][0])) {
                $bookInfo = $response['items'][0]['volumeInfo'];

                return [
                    'title' => $bookInfo['title'] ?? null,
                    'author' => isset($bookInfo['authors']) ? implode(', ', $bookInfo['authors']) : null,
                    'description' => $bookInfo['description'] ?? null,
                    'cover_url' => isset($bookInfo['imageLinks']['thumbnail']) ? $bookInfo['imageLinks']['thumbnail'] : null,
                    'publisher' => $bookInfo['publisher'] ?? null,
                    'published_date' => $bookInfo['publishedDate'] ?? null,
                    'page_count' => $bookInfo['pageCount'] ?? null,
                ];
            }
        } catch (\Exception $e) {
            // Log error but continue
            Log::error('Error fetching book metadata: ' . $e->getMessage());
        }

        return null;
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        try {
            $response = Http::get("https://www.googleapis.com/books/v1/volumes", [
                'q' => $query,
                'maxResults' => 5
            ]);

            if ($response->successful()) {
                $results = $response['items'] ?? [];
                return view('books.search-results', compact('results'));
            }
        } catch (\Exception $e) {
            // Log error
            Log::error('Error searching books: ' . $e->getMessage());
        }

        return view('books.search-results', ['results' => []]);
    }

    public function dashboard()
    {
        $totalBooks = Book::count();
        $readingCount = Book::where('status', 'Reading')->orWhere('status', 'Rereading')->count();
        $tbrCount = Book::where('status', 'TBR')->count();
        $readCount = Book::where('status', 'Read')->count();

        $currentlyReading = Book::where('status', 'Reading')
            ->orWhere('status', 'Rereading')
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        $recentlyAdded = Book::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('books.dashboard', compact(
            'totalBooks',
            'readingCount',
            'tbrCount',
            'readCount',
            'currentlyReading',
            'recentlyAdded'
        ));
    }
}
