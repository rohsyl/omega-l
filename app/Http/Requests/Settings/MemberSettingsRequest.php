<?php

namespace Omega\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Omega\Policies\OmegaGate;

class MemberSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return OmegaGate::allows('setting_member');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'acceptTermsEnabled' => 'required|boolean',
            'fileConditions' => 'nullable|exists:medias,id'
        ];
    }
}
