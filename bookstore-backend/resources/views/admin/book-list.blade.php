@extends('admin.layouts.adminApp')

@section('title', 'Login')

@section('content')
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Book List</h6>
                <a href="{{ route('add-book') }}" class="btn btn-primary m-2">Add Book</a>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Image</th>
                                <th scope="col">Title</th>
                                <th scope="col">Author</th>
                                <th scope="col">Publication Date</th>
                                <th scope="col">ISBN</th>
                                <th scope="col">Genre</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($books as $book)
                                <tr>
                                    <th scope="row">{{ $book->id }}</th>
                                    <td><img src="{{ asset('storage/' . $book->image) }}" alt="Book Image" width="100"></td>
                                    <td>{{ $book->title }}</td>
                                    <td>{{ $book->author }}</td>
                                    <td>{{ $book->published }}</td>
                                    <td>{{ $book->isbn }}</td>
                                    <td>{{ $book->genre }}</td>
                                    <td>
                                        <a href="{{ route('edit-book', $book->id) }}" class="btn btn-primary m-2">Edit Book</a>
                                        <form method="POST" id="deleteBookForm" action="{{ route('destroy-book', $book->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-primary m-2" type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $books->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Table End -->
@endsection
