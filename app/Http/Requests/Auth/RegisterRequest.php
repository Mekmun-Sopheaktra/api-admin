<?php

namespace App\Http\Requests\Auth;

use App\Traits\CheckUserPermission;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    use CheckUserPermission;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:255|min:3',
            'email' => 'required|unique:users|max:255|email',
            'password' => 'required',
        ];
    }
}
