<?php

namespace Omega\Http\Requests\Page\Module;

use Illuminate\Foundation\Http\FormRequest;

class CreateModuleRequest extends FormRequest
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
            'pageId' => 'required|integer|exists:pages,id',
            'pluginId' => 'required|integer|exists:plugins,id',
            'name' => 'required|string',
        ];
    }
}
