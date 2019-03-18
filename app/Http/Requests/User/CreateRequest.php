<?php

namespace Omega\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Omega\Policies\OmegaGate;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return OmegaGate::allows('user_add');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email',
            'fullname' => 'nullable|string',
            'password' => 'required|min:7',
            'password2' => 'required|same:password',
            'groups.*' => 'numeric',
            'rights.*' => 'numeric',
        ];
    }
}
