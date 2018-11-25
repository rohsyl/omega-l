<?php
namespace Omega\Http\Requests\Modulearea;

use Illuminate\Foundation\Http\FormRequest;

class SaveLangRequest extends FormRequest
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
            'posId' => 'required|integer|exists:positions,id',
            'posLang' => 'nullable|exists:langs,slug'
        ];
    }
}
