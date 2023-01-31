<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    body{
        background-color: bisque;
        color: blueviolet
    }
</style>
<body>
    <h1>Il post è : {{ $post->title }}</h1>
    <p>
        il testo è:
        {{ $post->body }}
    </p>
    <p>
        le categorie sono: {{ $post->category->name }}
    </p>
    <ul>
        @foreach ($post->tags as $elem)
          <li>{{ $elem->name }}</li>   
        @endforeach
    </ul>
</body>
</html>