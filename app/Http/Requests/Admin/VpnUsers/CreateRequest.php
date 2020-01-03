<?php


namespace App\Http\Requests\Admin\VpnUsers;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'login' => 'required|string|max:255',
            'group_id' => 'required|integer|max:255',
        ];
    }
}
