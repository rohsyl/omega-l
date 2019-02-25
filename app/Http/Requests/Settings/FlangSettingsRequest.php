<?php

namespace Omega\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class FlangSettingsRequest extends FormRequest
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
            'flang_enable' => 'required|boolean',
            'flang_default' => 'nullable|exists:langs,slug'
        ];
    }
}
