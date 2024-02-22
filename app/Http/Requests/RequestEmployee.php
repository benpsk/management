<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestEmployee extends FormRequest
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
            'first_name' => 'required|max:35',
            'last_name' => 'required|max:35',
            'email' => 'required|unique:employees,id' . $this->id,
            'address' => 'max:255',
            'phone' => 'max:12',
            'staff_id' => 'max:16',
            'department' => 'max:35',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Employee Fist Name is required',
            'last_name.required' => 'Employee Last Name is required'
        ];
    }
}
