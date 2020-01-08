<?php


namespace App\Http\Requests\Admin\VpnClientsTemplates;

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
            'protocol' => 'required|string|max:3',
            'host' => 'required|string|max:255',
            'port' => 'required|integer',
            'ca_file' => 'file',
            'cert_file' => 'file',
            'key_file' => 'file',
            'comment' => 'string|max:255',
        ];
    }
}
