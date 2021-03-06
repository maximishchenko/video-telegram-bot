<?php


namespace App\Http\Requests\Profile;

use App\Shared;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255|unique:users,id,' . $this->id,
            'email' => 'required|string|max:255|email|unique:users,id,' . $this->id,
        ];
    }
}
