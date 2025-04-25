<?php

namespace App\Http\Controllers;

use App\Http\Requests\Posts\StorePostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

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
      $user = User::find(Auth::id());

      try {
        $post = Post::create([
          'title' => $data['postTitleInput'],
          'author_id' => $user->id,
          'slug' => Str::slug($data['postTitleInput']),
          'category' => $data['postCategoryInput'],
          'content' => $data['postContent'],
        ]);

        return redirect()->route('posts.show', [$user->name, $post->slug], Response::HTTP_SEE_OTHER)
                         ->with('success', "Post $post->title criado com sucesso");

      } catch (\Exception $e) {
        return response()->json([
          'message' => 'Error: ' . $e->getMessage(),
        ], 500);
      }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $author, string $slug)
    {
        $post = Post::findByOwnerAndSlug($author, $slug);

        if (!$post) {
          return Inertia::render('404');
        }

        return Inertia::render('Posts/PostView', [
          'post' => $post,
          session('success') ? 'success' : null,
        ]);
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
