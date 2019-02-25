<?php

namespace Omega\Http\Requests\Group;

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
        return OmegaGate::allows('group_edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'users.*' => 'numeric',
            'rights.*' => 'numeric',
        ];
    }
}
