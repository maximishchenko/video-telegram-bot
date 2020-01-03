<?php


namespace App\Http\Requests\Admin\VpnUsers;


use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'password_plain' => 'required|string|min:6|confirmed',
        ];
    }
}
