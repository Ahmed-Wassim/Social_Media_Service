<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
            'email' => 'required|string|email|unique:users',
            'username' => 'required|string|regex:/^\S*$/',
            'password' => ['required', 'string', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
            'image' => 'mimes:png,jpg|max:1024',
        ];
    }


    //save time with ChatGpt
    public function messages()
    {
        return [
            // Email field
            'email.required' => 'The email field is required.',
            'email.string' => 'The email must be a valid string.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'This email is already registered.',

            // Username field
            'username.required' => 'The username field is required.',
            'username.string' => 'The username must be a valid string.',
            'username.regex' => 'The username must not contain spaces.',

            // Password field
            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a valid string.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.mixedCase' => 'The password must include both uppercase and lowercase letters.',
            'password.numbers' => 'The password must include at least one number.',
            'password.symbols' => 'The password must include at least one special character.',

            // Image field
            'image.mimes' => 'The image must be a file of type: png, jpg.',
            'image.max' => 'The image may not be larger than 1MB.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422));
    }
}
