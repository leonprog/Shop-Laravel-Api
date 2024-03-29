<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users,email,'. $this->user()->id,
            'old_password' => [
                'required_with:password',
                function($attribute, $value, $fail) {
                    $user = $this->user();
                    if($this->request->get('password') && !Hash::check($value, $user->password)) {
                        $fail('incorrect password');
                    }
                }
            ],
            'password' => 'sometimes|confirmed|min:6',
        ];
    }
}
