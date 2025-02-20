<?php

namespace App\Http\Requests\Auth;

use Illuminate\Validation\Rules;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class RegisteredUserRequest extends FormRequest
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
          'name' => ['required', 'string', 'max:255', 'regex:/^[^\s]+$/', 'unique:App\Models\User,name'],
          'email' => ['required', 'string', 'email', 'max:255', 'unique:App\Models\User,email'],
          'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nome',
            'email' => 'E-mail',
            'password' => 'Senha',
        ];
    }

    public function messages(): array
    {
      return [
        'required' => 'O campo :attribute é obrigatório.',
        'max' => 'O campo :attribute contém muitos caracteres',
        'unique' => 'O campo :attribute já está em uso.',
        'email' => 'O campo :attribute deve ser um e-mail válido.',
        'regex' => 'O campo :attribute não pode conter espaços.',
      ];
    }
}
