<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AddClassRequest extends Request
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
            //
            'class_name' => 'required',
            'academic_year' => 'required',
            'staff' => 'required',
            'subject_id' => 'required',
        ];
    }
}
