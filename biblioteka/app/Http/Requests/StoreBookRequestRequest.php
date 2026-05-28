<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // public form — anyone may submit
    }

    public function rules(): array
    {
        return [
            'reader_name' => ['required', 'string', 'min:3', 'max:100'],
            'contact'     => ['required', 'string', 'max:150', 'regex:/^([\w.+\-]+@[\w\-]+\.[\w.\-]+|\+?\d[\d\s\-()\/.]{5,})$/'],
            'notes'       => ['nullable', 'string', 'max:280'],
            'consent'     => ['accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'reader_name.required' => 'Unesite vaše ime i prezime.',
            'reader_name.min'      => 'Ime mora imati najmanje 3 znaka.',
            'reader_name.max'      => 'Ime ne može biti duže od 100 znakova.',
            'contact.required'     => 'Unesite email adresu ili broj telefona.',
            'contact.regex'        => 'Unesite ispravan email ili broj telefona (npr. milica@primer.rs ili +381 64 123 4567).',
            'contact.max'          => 'Kontakt ne može biti duži od 150 znakova.',
            'notes.max'            => 'Napomena ne može biti duža od 280 znakova.',
            'consent.accepted'     => 'Potrebno je da prihvatite obradu podataka.',
        ];
    }
}
