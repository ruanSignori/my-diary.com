<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comments\FormCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
  /**
   * Store a newly created comment
   */
  public function store(FormCommentRequest $request)
  {
    $data = $request->validated();

    $post = Post::findOrFail($data['post_id']);

    if (!$post) {
      return back()->with([
        'flash.message' => 'Postagem não encontrada!',
        'flash.type' => 'error'
      ]);
    }

    Comment::create([
      'post_id' => $data['post_id'],
      'user_id' => Auth::id(),
      'content' => $data['content'],
      'parent_id' => $data['parent_id'] ?? null,
    ]);

    return back()->with([
      'flash.message' => 'Comentário adicionado com sucesso!',
      'flash.type' => 'success'
    ]);
  }

  /**
   * Update the specified comment
   */
  public function update(FormCommentRequest $request, Comment $comment)
  {
    $data = $request->validated();

    $post = Post::findOrFail($data->post_id);

    if (!$post) {
      return back()->with([
        'flash.message' => 'Postagem não encontrada!',
        'flash.type' => 'error'
      ]);
    }

    if (Gate::denies('modify-comment', $comment)) {
      return back()->with([
        'flash.message' => 'Você não tem permissão para editar este comentário!',
        'flash.type' => 'error'
      ]);
    }

    $comment->update([
      'content' => $data->content
    ]);

    return back()->with([
      'flash.message' => 'Comentário atualizado com sucesso!',
      'flash.type' => 'success'
    ]);
  }

  /**
   * Remove the specified comment
   */
  public function destroy(Comment $comment)
  {
    if (Gate::denies('modify-comment', $comment)) {
      return back()->with([
        'flash.message' => 'Você não tem permissão para excluir este comentário!',
        'flash.type' => 'error'
      ]);
    }
    $now = date('Y-m-d H:i:s');
    $comment->update(['deleted_at' => $now]);

    return back()->with([
      'flash.message' => 'Comentário excluído com sucesso!',
      'flash.type' => 'success'
    ]);
  }
}
