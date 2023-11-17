<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Http\Mock\Client;
use Nyholm\Psr7\Response;
class BookController extends Controller
{

    public function index(Request $request)
    {

        $mock = new Client(); // This is the mock client


    $search = 'book';

// Set up a PSR-7 response for the search endpoint
        $response = new Response(
            200,
            ['Content-Type' => 'application/json'],
            json_encode(['hits' => ['hits' => [['_id' => '1', '_source' => ['title' => 'Book 1']]]]])
        );

        // Add the response to the mock client
        $mock->addResponse($response);

        $elasticsearch = ClientBuilder::create()
            ->setHttpClient($mock)
            ->build();

        $params = [
            'index' => 'books',
            'body' => [
                'query' => [
                    'bool' => [
                        'should' => [
                            ['match' => ['title' => $search]],
                        ],
                    ],
                ],
            ],
        ];

        $response = $elasticsearch->search($params);

        // Extract the IDs of matching records from the Elasticsearch response
        $matchingIds = collect($response['hits']['hits'])->pluck('_id')->toArray();

        $query = Book::whereIn('id', $matchingIds);

        // Apply other filters...

        $books = $query->paginate(10);

        return response()->json($books);
    }

    // public function index(Request $request)
    // {
    //     $query = Book::query();
    //     if ($request->has('search')) {
    //         $search = $request->input('search');
    //         $query->where(function ($q) use ($search) {
    //             $q->where('title', 'like', '%' . $search . '%')
    //                 ->orWhere('author', 'like', '%' . $search . '%')
    //                 ->orWhere('genre', 'like', '%' . $search . '%')
    //                 ->orWhere('isbn', 'like', '%' . $search . '%')
    //                 ->orWhere('published', 'like', '%' . $search . '%');
    //         });
    //     }
    //     // Apply filter by author if provided
    //     if ($request->has('author')) {
    //         $author = $request->input('author');
    //         $query->where('author', 'like', '%' . $author . '%');
    //     }
    //     // Apply filter by genre if provided
    //     if ($request->has('genre')) {
    //         $genre = $request->input('genre');
    //         $query->where('genre', 'like', '%' . $genre . '%');
    //     }
    //     // Apply filter by isbn if provided
    //     if ($request->has('isbn')) {
    //         $isbn = $request->input('isbn');
    //         $query->where('isbn', 'like', '%' . $isbn . '%');
    //     }
    //     // Apply filter by published if provided
    //     if ($request->has('published')) {
    //         $published = $request->input('published');
    //         $query->where('published', 'like', '%' . $published . '%');
    //     }
    //     $books = $query->paginate(10);
    //     return response()->json($books);
    // }

    public function showBookList()
    {
        $perPage = 10;
        $page = request()->get('page', 1);
        $books = Book::all();
        $paginatedBooks = new LengthAwarePaginator(
            $books->forPage($page, $perPage),
            $books->count(),
            $perPage,
            $page,
            ['path' => route('books')]
        );
        return view('admin.book-list', ['books' => $paginatedBooks]);
    }

    public function addBook()
    {
        return view('admin.add-book');
    }

    public function storeBook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'author' => 'required',
            'genre' => 'required',
            'description' => 'required',
            'isbn' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'published' => 'required',
            'publisher' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/add-book')->withErrors($validator)->withInput();
        }

        $imagePath = $request->file('image')->store('book_images', 'public');

        $book = Book::create([
            'title' => $request->input('title'),
            'author' => $request->input('author'),
            'genre' => $request->input('genre'),
            'description' => $request->input('description'),
            'isbn' => $request->input('isbn'),
            'image' => $imagePath,
            'published' => $request->input('published'),
            'publisher' => $request->input('publisher'),
        ]);

        return redirect('/add-book')->with('success', 'Book added successfully');
    }

    public function editBook($id)
    {
        $book = Book::findOrFail($id);
        return view('admin.edit-book', compact('book'));
    }

    public function updateBook(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'genre' => 'required',
            'description' => 'required',
            'isbn' => 'required|numeric',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'published' => 'required|date',
            'publisher' => 'required',
        ]);

        $book = Book::findOrFail($id);

        $book->update([
            'title' => $request->input('title'),
            'author' => $request->input('author'),
            'genre' => $request->input('genre'),
            'description' => $request->input('description'),
            'isbn' => $request->input('isbn'),
            'published' => $request->input('published'),
            'publisher' => $request->input('publisher'),
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('book_images', 'public');
            $book->update(['image' => $imagePath]);
        }

        return redirect('/books')->with('success', 'Book updated successfully');
    }

    public function destroyBook($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect('/books')->with('success', 'Book deleted successfully');
    }

}