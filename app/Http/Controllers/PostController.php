<?php

namespace App\Http\Controllers;

use App\Http\Requests\Posts\StorePostRequest;
use App\Models\Category;
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
    // Busca todas as categorias disponíveis
    $categories = Category::select('id', 'name')
      ->get()
      ->map(fn($category) => [
        'value' => $category->id,
        'label' => $category->name,
      ])
      ->toArray();

    return Inertia::render('Posts/PostCreate', [
      'categories' => $categories,
    ]);
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
        'content' => $data['postContent'],
      ]);

      $categories = $data['existingCategories'];

      // Criar e adicionar novas categorias
      if (!empty($data['newCategories'])) {
        foreach ($data['newCategories'] as $categoryName) {
          $category = Category::where('name', 'ILIKE', $categoryName)->first();

          if (!$category) {
              $category = Category::create([
                  'name' => $categoryName,
              ]);
          }

          $categories[] = $category->id;
        }
      }

      // Associa as categorias ao post
      foreach ($categories as $categoryId) {
        $post->categories()->attach($categoryId);
      }

      return redirect()->route('posts.show', [$user->name, $post->slug], Response::HTTP_SEE_OTHER)
        ->with('success', "Post $post->title criado com sucesso");
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'Error: ' . $e->getMessage(),
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
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
