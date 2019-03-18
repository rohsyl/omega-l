<?php

namespace Omega\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Omega\Policies\OmegaGate;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return OmegaGate::allows('user_update_data') ||
            OmegaGate::allows('user_update_himself') ||
            OmegaGate::allows('user_update_rights') ||
            OmegaGate::allows('user_update_group');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'fullname' => 'nullable|string',
            'groups.*' => 'numeric',
            'rights.*' => 'numeric',
        ];
    }
}
