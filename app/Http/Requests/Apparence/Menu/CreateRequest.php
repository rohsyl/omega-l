<?php

namespace Omega\Http\Requests\Apparence\Menu;

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
        return OmegaGate::allows('menu_add');
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
            'isMain' => 'required|boolean',
            'lang' => 'nullable',
            'membergroup' => 'required',
        ];
    }
}
