<?php

namespace Omega\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;
use Omega\Policies\OmegaGate;

class UpdateMemberGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return OmegaGate::allows('membergroup_update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
