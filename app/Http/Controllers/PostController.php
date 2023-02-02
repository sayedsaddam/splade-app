<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Models\Category;
use App\Models\Post;
use App\Tables\Posts;
use ProtoneMedia\Splade\Facades\Toast;

class PostController extends Controller
{
    public function index(){
        return view('posts.index', [
            'posts' => Posts::class
        ]);
    }
    public function create(){
        $categories = Category::pluck('name', 'id')->toArray();
        return view('posts.create', compact('categories'));
    }
    public function store(PostStoreRequest $request){
        Post::create($request->validated());
        Toast::title('Post was added successfully!');
        return to_route('posts.index');
    }
    public function edit(Post $post){
        $categories = Category::pluck('name', 'id')->toArray();
        return view('posts.edit', compact('post', 'categories'));
    }
    public function update(PostStoreRequest $request, Post $post){
        $post->update($request->validated());
        Toast::title('Post was updated successfully!');
        return to_route('posts.index');
    }
    public function destroy(Post $post){
        $post->delete();
        Toast::title('Post was deleted successfully!');
        return redirect()->back();
    }
}
