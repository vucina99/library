<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
         return Auth::check();;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstName' => 'required|min:2|max:100',
            'lastName' => 'required|min:2|max:100',
            'email' => 'required|unique:users|email',
            'password' => 'required|alpha_dash|min:6',
            'role' => 'required|integer',
        ];
    }
}
