<?php

namespace Omega\Http\Requests\Page;

use Illuminate\Foundation\Http\FormRequest;
use Omega\Policies\OmegaGate;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return OmegaGate::allows('page_update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tab' => 'required|string',

            // langs
            'lang' => 'nullable|exists:langs,slug',
            // TODO : make this rule work ...
            //'plangs_rel.*' => 'sometimes|nullable|integer|exists:pages,id',
            'plangs_rel.*' => 'nullable',

            // parameters
            'showName' => 'required|boolean',
            'name' => 'required|string',
            'showSubtitle' => 'required|boolean',
            'subtitle' => 'nullable|string',
            'slug' => 'required|string',
            'parent' => 'nullable|integer|exists:pages,id',
            'model' => 'nullable|string',
            'menu' => 'nullable|string',
            'cssTheme' => 'nullable|string',
            'keyword' => 'nullable|string|regex:/^[a-zA-Z0-9-]*[a-zA-Z0-9]+(?:,[a-zA-Z0-9-]*[a-zA-Z0-9]+)*$/',

            // security
            'security' => 'required|in:none,bypassword,bymember',
            'security_message' => 'nullable|string',
            'security_password' => 'nullable|string',
            'security_membergroup' => 'nullable|integer|exists:membergroups,id',
        ];
    }
}
