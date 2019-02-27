<?php

namespace Omega\Http\Requests\Settings\Flang;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFlangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return OmegaGate::allows('setting_flang');
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
            'enabled' => 'required|boolean',
            'fkMedia' => 'nullable|integer|exists:medias,id',
        ];
    }
}
