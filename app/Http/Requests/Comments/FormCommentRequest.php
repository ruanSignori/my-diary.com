<?php

namespace App\Http\Requests\Comments;

use Illuminate\Foundation\Http\FormRequest;

class FormCommentRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'post_id' => 'required|exists:posts,id',
      'content' => 'required|string|max:5000',
      'parent_id' => 'nullable|exists:comments,id'
    ];
  }

  public function messages(): array
  {
    return [
      'post_id.required' => 'O campo Postagem é obrigatório.',
      'post_id.exists' => 'A Postagem selecionada não existe.',
      'content.required' => 'O campo Conteúdo é obrigatório.',
      'content.max' => 'O Conteúdo não pode ter mais que :max caracteres.',
      'parent_id.exists' => 'O Comentário principal não existe.'
    ];
  }
}
