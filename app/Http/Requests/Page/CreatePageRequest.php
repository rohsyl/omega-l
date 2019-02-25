<?php

namespace Omega\Http\Requests\Page;

use Illuminate\Foundation\Http\FormRequest;
use Omega\Policies\OmegaGate;

class CreatePageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return OmegaGate::allows('page_add');
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
            'lang' => 'nullable|string|exists:langs,slug',
            'parent' => 'nullable',
        ];
    }
}
