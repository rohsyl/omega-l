<?php

namespace Omega\Http\Requests\Medias;

use Illuminate\Foundation\Http\FormRequest;
use Omega\Policies\OmegaGate;

class MkdirRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return OmegaGate::allows('can_access_media_library');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'newfolder' => 'required|string',
            'parent' => 'required|integer|exists:medias,id'
        ];
    }
}
