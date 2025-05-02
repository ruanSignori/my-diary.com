<?php

namespace App\Http\Requests\Posts;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
        'postTitleInput' => 'required|string|max:255',
        'existingCategories' => 'nullable|array|required_without:newCategories',
        'newCategories' => 'nullable|array|required_without:existingCategories',
        'postContent' => 'required|string|min:10',
      ];
    }

    public function messages(): array
    {
      return [
        'postTitleInput.required' => 'O campo Título é obrigatório.',
        'postTitleInput.max' => 'O Título não pode ter mais que :max caracteres.',
        'existingCategories.required_without' => 'Você precisa selecionar pelo menos uma Categoria existente ou criar uma nova.',
        'newCategories.required_without' => 'Você precisa adicionar pelo menos uma Nova Categoria ou selecionar uma existente.',
        'postContent.required' => 'O campo Conteúdo é obrigatório.',
        'postContent.min' => 'O Conteúdo deve ter pelo menos :min caracteres.',
      ];
    }
}
