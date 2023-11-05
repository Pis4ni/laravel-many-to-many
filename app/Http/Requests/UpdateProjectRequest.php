<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            'title' => 'required|string|max:40',
            "description" => "required|string|min:20",

            // *------------------------------------------------------*
            'cover_image' => ['nullable'],
            // *------------------------------------------------------*
            'type_id' => ['nullable', 'exists:types,id'],
            // *------------------------------------------------------*
            'technologies' => ['nullable', 'exists:technologies,id'],
        ];
    }
    public function messages()
    {
        return [

            // *titolo
            'title.required' => 'Il titolo è obbligatorio',
            'title.string' => 'Il titolo deve essere una stringa',
            'title.max' => 'Il titolo deve massimo di 40 caratteri',

            // *descrizione
            'description.required' => 'La descrizione è obbligatoria',
            'description.string' => 'La descrizione deve essere una stringa',
            'description.min' => 'La descrizione deve essere lunga almeno 50 caratter',

            // *------------------------------------------------------*
            'type_id.exists' => 'La categoria inserita non è valida',
            // *------------------------------------------------------*
            'cover_image.image' => 'il file selezionato deve essere un\'immagine',
            'cover_image.max' => 'il file selezionato deve essere massimo di 512KB',
            // *------------------------------------------------------*
            'technologies.exists' => 'I technology inseriti non sono validi',
    ];
    }
}
