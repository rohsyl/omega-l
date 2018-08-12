<?php

namespace Omega\Http\Requests\Install;

use Illuminate\Foundation\Http\FormRequest;

class SiteAndUserRequest extends FormRequest
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
            'title' => 'required',
            'slogan' => 'required',
            'email' => 'required|email',
            'username' => 'required',
            'password' => 'required|min:7|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/',
            'password2' => 'required|same:password',
        ];
    }
}
