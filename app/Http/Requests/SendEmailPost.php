<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendEmailPost extends FormRequest
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
            'app_id' => 'required|string',
            'subject' => 'required|string',
            'from' => 'email',
            'fromName' => 'string',
            'to' => 'required|email',
            'toName' => 'string',
            'contentType' => 'required|string',
            'content' => 'required'
        ];
    }
}
