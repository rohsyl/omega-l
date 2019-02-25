<?php

namespace Omega\Http\Requests\Apparence\Menu;

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
        return OmegaGate::allows('menu_update');
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
            'json' => 'required',
            'membergroup' => 'required|exists:membergroups,id',
            'isMain' => 'required|boolean',
            'lang' => 'nullable|string',
        ];
    }
}
