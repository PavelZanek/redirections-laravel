<?php

namespace PavelZanek\RedirectionsLaravel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportRedirectsRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'csv' => 'max:10240|required|mimes:csv,txt',
        ];
    }
}
