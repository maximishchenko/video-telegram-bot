<?php


namespace App\Http\Requests\Admin\VpnUsers;

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
        if (Gate::allows('admin')) {
            return [
                'name' => 'required|string|max:255',
                'login' => 'required|string|max:255',
                'group_id' => 'required|integer|max:255',
            ];
        } else {
            return [
                'name' => 'required|string|max:255',
                'login' => 'required|string|max:255',
                'group_id' => 'required|integer|max:255|in:' . implode(',', Auth::user()->vpngroups()->allRelatedIds()->toArray()),
            ];
        }

    }
}
