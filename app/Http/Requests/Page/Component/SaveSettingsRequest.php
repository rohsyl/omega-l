<?php

namespace Omega\Http\Requests\Page\Component;

use Illuminate\Foundation\Http\FormRequest;

class SaveSettingsRequest extends FormRequest
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
            'compId' => 'nullable|string',
            'compTitle' => 'nullable|string',
            'is_hidden' => 'required|boolean',
            'comp_width' => 'required|in:wrapped,full-width',
            'bgcolor' => 'required|in:transparent,custom,theme',
            'customcolor' => 'nullable|string',
            'themecolor' => 'nullable|string',
            'compTemplate' => 'nullable|string',
        ];
    }
}
