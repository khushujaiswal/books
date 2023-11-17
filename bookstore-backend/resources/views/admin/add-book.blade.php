@extends('admin.layouts.adminApp')

@section('title', 'Login')

@section('content')

<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Add Book</h6>
                <form method="POST" enctype="multipart/form-data" action="{{ url('/store-book') }}">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">title</label>
                        <input type="text" name="title" class="form-control" >
                        @error('book.title') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">author</label>
                        <input type="text" name="author" class="form-control" >
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">genre</label>
                        <input type="text" name="genre" class="form-control" >
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">description</label>
                        <textarea name="description" class="form-control" ></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">isbn</label>
                        <input type="number" name="isbn" class="form-control" >
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">image</label>
                        <input type="file" name="image" class="form-control" >
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">published</label>
                        <input type="date" name="published" class="form-control" >
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">publisher</label>
                        <input type="text" name="publisher" class="form-control" >
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Form End -->
@endsection