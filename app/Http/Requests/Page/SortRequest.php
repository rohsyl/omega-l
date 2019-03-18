<?php

namespace Omega\Http\Requests\Page;

use Illuminate\Foundation\Http\FormRequest;
use Omega\Policies\OmegaGate;

class SortRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return OmegaGate::allows('page_read');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'order' => 'required'
        ];
    }
}
