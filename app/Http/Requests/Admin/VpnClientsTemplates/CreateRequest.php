<?php


namespace App\Http\Requests\Admin\VpnClientsTemplates;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
                'protocol' => 'required|string|max:3',
                'host' => 'required|string|max:255',
                'port' => 'required|integer',
                'ca_file' => 'required',
                'cert_file' => 'required',
                'key_file' => 'required',
                'comment' => 'nullable|string|max:255',
            ];

    }
}
