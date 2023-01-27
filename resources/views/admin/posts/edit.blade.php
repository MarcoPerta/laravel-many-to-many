@extends('layouts.dashboard')

@section('content')
<div class="text-center">
    <h1>Modifico il post</h1>  
    {{-- {{ $post->title }} --}}
</div>

<form action="{{ route('admin.posts.update', $post->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="my-3">
        <label class="form-label" for="">titolo</label>
        <input value="{{ $post->title }}" class="form-control @error('title') is-invalid @enderror" type="text" name="title">
        @error('title')
           <div class="alert alert-danger">
               {{ $message }}
           </div>
        @enderror
    </div>

    <div class="my-3">
        <label class="form-label" for="">body</label>
        <textarea class="form-control @error('body') is-invalid @enderror" name="body" {{ $post->body }} ></textarea>
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
                        {{ $category->id = old('category_id' , $post->category_id) ? 'selected' : '' }}
                        {{ $category->name }}
                    </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Modifica</button>
</form>
    
@endsection