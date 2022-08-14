<?php

namespace PavelZanek\RedirectionsLaravel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use PavelZanek\RedirectionsLaravel\Enums\StatusCode;

class StoreRedirectRequest extends FormRequest
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
            'source_url' => 'required|url|unique:redirects,source_url',
            'target_url' => 'required|url',
            'status_code' => ['required', new Enum(StatusCode::class)]
        ];
    }
}
