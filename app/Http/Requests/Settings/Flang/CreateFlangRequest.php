<?php

namespace Omega\Http\Requests\Settings\Flang;

use Illuminate\Foundation\Http\FormRequest;
use Omega\Policies\OmegaGate;

class CreateFlangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return OmegaGate::allows('setting_general');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'slug' => 'required|string|size:2',
            'name' => 'required|string',
            'enabled' => 'required|boolean',
            'fkMedia' => 'nullable|integer|exists:medias,id',
        ];
    }
}
