<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        return Inertia::render('Home');
    }

    public function create()
    {
        return Inertia::render('Posts/PostCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
      $data = $request->validated();
      $author_id = User::find(Auth::id());

      try {
        $post = Post::create([
          'title' => $data['postTitleInput'],
          'author_id' => $author_id->id,
          'slug' => Str::slug($data['postTitleInput']),
          'category' => $data['postCategoryInput'],
          'content' => $data['postContent'],
        ]);

        return redirect()->route('posts.show', [$post->author_id, $post->slug], 303);

      } catch (\Exception $e) {
        return response()->json([
          'message' => 'Error: ' . $e->getMessage(),
        ], 500);
      }
    }

    /**
     * Display the specified resource.
     */
    public function show($author_id, $slug)
    {
        $post = Post::findByOwnerAndSlug($author_id, $slug);

        if (!$post) {
          return Inertia::render('404');
        }

        return response()->json($post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
