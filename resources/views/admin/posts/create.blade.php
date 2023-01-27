@extends('layouts.dashboard')

@section('content')
<div class="text-center">
    <h1>Creo un post</h1>  
</div>

<form action="{{ route('admin.posts.store') }}" method="POST">
    @csrf

    <div class="my-3">
        <label class="form-label" for="">titolo</label>
        <input class="form-control @error('title') is-invalid @enderror" type="text" name="title">
        @error('title')
           <div class="alert alert-danger">
               {{ $message }}
           </div>
        @enderror
    </div>

    <div class="my-3">
        <label class="form-label" for="">body</label>
        <textarea class="form-control @error('body') is-invalid @enderror" name="body"></textarea>
        @error('body')
           <div class="alert alert-danger">
               {{ $message }}
           </div>
        @enderror
    </div>

    <div class="my-3">
        <label for="">Categories</label>
        <select class="form-control" name="category_id" id="">
            @foreach ($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Tags</label>

        @foreach ($tags as $tag)
            <label for="">
                <input type="checkbox" name="tags[]" value="{{ $tag->id }}">
                {{ $tag->name }}
            </label>
        @endforeach

    </div>

    <button type="submit" class="btn btn-primary">Crea</button>
</form>
    
@endsection