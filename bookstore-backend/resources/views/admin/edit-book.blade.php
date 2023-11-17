@extends('admin.layouts.adminApp')

@section('title', 'Edit Book')

@section('content')

<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Edit Book</h6>
                <form method="POST" enctype="multipart/form-data" action="{{ url('/update-book/' . $book->id) }}">
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ $book->title }}">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Author</label>
                        <input type="text" name="author" class="form-control" value="{{ $book->author }}">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Genre</label>
                        <input type="text" name="genre" class="form-control" value="{{ $book->genre }}">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Description</label>
                        <textarea name="description" class="form-control">{{ $book->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">ISBN</label>
                        <input type="number" name="isbn" class="form-control" value="{{ $book->isbn }}">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Image</label>
                        <input type="file" name="image" class="form-control">
                        <br>
                        <img src="{{ asset('storage/' . $book->image) }}" alt="Book Image" width="100"><br>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Published</label>
                        <input type="date" name="published" class="form-control" value="{{ $book->published }}">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Publisher</label>
                        <input type="text" name="publisher" class="form-control" value="{{ $book->publisher }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Form End -->
@endsection