<?php

namespace Omega\Http\Requests\Medias;

use Illuminate\Foundation\Http\FormRequest;

class UploaderRequest extends FormRequest
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
            'parent' => 'required|integer|exists:medias,id',
            'replace' => 'nullable|integer|exists:medias,id'
        ];
    }
}
