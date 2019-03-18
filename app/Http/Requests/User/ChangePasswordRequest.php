<?php

namespace Omega\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Omega\Policies\OmegaGate;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return  OmegaGate::allows('user_update_data') ||
            OmegaGate::allows('user_update_himself');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required|string',
            'password2' => 'required|same:password',
        ];
    }
}
