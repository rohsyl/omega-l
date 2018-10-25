<?php

namespace Omega\Http\Requests\Modulearea;

use Illuminate\Foundation\Http\FormRequest;

class AddPositionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'areaName' => 'required|string|exists:module_areas,name',
            'moduleId' => 'required|integer|exists:modules,id'
        ];
    }
}
