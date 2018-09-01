<?php

namespace Omega\Http\Requests\Medias;

use Illuminate\Foundation\Http\FormRequest;

class RenameRequest extends FormRequest
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
            'id' => 'required|integer|exists:medias,id',
            'newname' => 'required|string'
        ];
    }
}
