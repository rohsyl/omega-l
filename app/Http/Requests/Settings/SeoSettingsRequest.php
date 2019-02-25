<?php

namespace Omega\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Omega\Policies\OmegaGate;

class SeoSettingsRequest extends FormRequest
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
            'keywords' => 'string|nullable|regex:/^[a-zA-Z0-9-]*[a-zA-Z0-9]+(?:,[a-zA-Z0-9-]*[a-zA-Z0-9]+)*$/',
            'description' => 'string|nullable|regex:/^[a-zA-Z0-9-]*[a-zA-Z0-9]+(?:,[a-zA-Z0-9-]*[a-zA-Z0-9]+)*$/'
        ];
    }
}
