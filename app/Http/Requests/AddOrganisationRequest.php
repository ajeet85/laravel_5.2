<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AddOrganisationRequest extends Request
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
            'org_id' => 'required',
            'org_name' => 'required',
            'org_address' => 'required',
            'account_id' => 'required',
        ];
    }
}
