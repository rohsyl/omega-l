<?php

namespace Omega\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Omega\Utils\Language\BackLangManager;

class GeneralSettingsRequest extends FormRequest
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
            'lang' => 'required|in:' . BackLangManager::getAllLangAsString(),
            'title' => 'required|max:255',
            'slogan' => 'nullable|max:255',
            'web_adress' => 'required|url|max:255',
            //'home' => 'required|integer'
        ];
    }
}
