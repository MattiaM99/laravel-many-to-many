<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $posts = Post::orderBy('id','desc')->paginate(5);
        return view('admin.posts.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
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
      $request->validate(
      [
        'title' => 'required|min:2|max:255',
        'content' => 'min:5'
      ],
      [
        'title.required' => 'Il titolo è un campo obbligatorio.',
        'title.min' => 'Il titolo deve essere lungo almeno :min caratteri.',
        'title.max' => 'Il titolo deve essere lungo massimo :max caratteri',
        'content.min' => 'Il contenuto deve essere lungo almeno :min caratteri'
      ]);
      
        $data = $request->all();
        $newPost = new Post();
        $newPost->fill($data);
        $newPost->slug = Post::generateUniqueSlug($newPost->title);
        $newPost->save();

        if(array_key_exists('tags', $data)){
          $newPost->tags()->attach($data['tags']);
        }

        return redirect()->route('admin.posts.show', $newPost)->with('success', 'Nuovo post creato correttamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        if (!$post) {
          abort(404);
        }
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $categories = Category::all();
      $tags = Tag::all();
      $post = Post::find($id);
      if (!$post) {
        abort(404);
      }
      return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate(
          [
            'title' => 'required|min:2|max:255',
            'content' => 'min:5'
          ],
          [
            'title.required' => 'Il titolo è un campo obbligatorio.',
            'title.min' => 'Il titolo deve essere lungo almeno :min caratteri.',
            'title.max' => 'Il titolo deve essere lungo massimo :max caratteri',
            'content.min' => 'Il contenuto deve essere lungo almeno :min caratteri'
          ]);

          $data = $request->all();
          if ($data['title'] != $post->title) {
            $data['slug'] = Post::generateUniqueSlug($data['title']);
          }

          $post->update($data);

          if(array_key_exists('tags', $data)){
            $post->tags()->sync($data['tags']);
          }else {
            $post->tags()->detach();
          }

          return redirect()->route('admin.posts.show', $post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('deleted', 'Post eliminato correttamente');
    }
}