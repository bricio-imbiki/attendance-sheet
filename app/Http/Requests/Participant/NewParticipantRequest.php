<?php

namespace App\Http\Requests\Participant;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class NewParticipantRequest extends FormRequest
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
            "nom" => ['required', 'min:2', 'max:255'],
            "prenoms" => ['nullable', 'min:2', 'max:255'],
            "email" => ['nullable', 'email'],
            "contact" => ['required', 'min:10', 'max: 10'],
            "organisation" => ["nullable", "min:4", "max:255"]
        ];
    }
}
