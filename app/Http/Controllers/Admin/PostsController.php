<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use App\Category;
use App\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Mail\CreatePostMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = [
            'posts' => Post::with('category', 'tags')->paginate(10)
        ];

        return view ('admin.posts.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::All();
        $tags = Tag::All();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        // dd($data);
        // Validazione
        $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $newPost = new Post();
        // controllo se l'img è stata caricata nel input
        // dd($data);
        if( array_key_exists('image', $data) ){
            $cover_url = Storage::put('post_covers' , $data['image']);
            //dd($cover_url );
            $data['cover'] = $cover_url;
        }
        $newPost->fill($data);
        $newPost->save();

        // controllo se l'utente ha cliccato le checbox
        if ( array_key_exists( 'tags', $data ) ){
            $newPost->tags()->sync( $data['tags']);
        }

        // invio mail di creazione
        $mail = new CreatePostMail($newPost);
        $email_utente = Auth::user()->email;
        Mail::to($email_utente)->send($mail);

        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $singolo_post = Post::findOrFail($id);

        return view('admin.posts.show',compact('singolo_post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        $categories = Category::All();

        $tags = Tag::All();

        return view('admin.posts.edit', compact('post','categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $requets->all();
        $singoloPost = Post::findOrFail($id);

        $singoloPost->update($data);

        // controllo se l'utente ha cliccato le checbox
        if ( array_key_exists( 'tags', $data ) ){
            $singoloPost->tags()->sync( $data['tags']);
        }else{
            // non ci sono checkbox selezionate
            $singoloPost->tags()->sync([]);
        }


        return redirect()->route('admin.posts.show', $singoloPost->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $singoloPost = Post::findOrFail($id);
        $singoloPost->tags()->sync([]);
        $singoloPost->delete();

        return redirect()->route('admin.posts.index');
    }
}
