<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
            'title' => 'required|max:255|unique:projects',
            'description' => 'required|max:65635',
            'url' => 'nullable|image|max:1024',
            'type_id' => 'nullable|exists:types,id',
            'technologies' =>'exists:technologies,id'
            
        ];

    }
    public function messages()
    {
        return[
            'title.required' => 'Titolo richiesto',
            'title.max' => 'Lunghezza massima titolo è di 100 caratteri',

            'description.required' => 'La descrizione è richiesta',
            'description.max' => 'Lunghezza massima descrizione è di 65535 caratteri',

            'url.image' => 'L\'URL inserito non è valido',
            'url.max' => 'Lunghezza massima dell\'url è di 255 caratteri',

    

        ];
    }
}