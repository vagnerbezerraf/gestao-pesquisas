<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Converte string CSV de emails em array antes da validação.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('emails') && !is_array($this->emails)) {
            $emailsArray = array_filter(array_map('trim', explode(',', $this->emails)));
            $this->merge(['emails' => $emailsArray]);
        }
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'emails' => 'required|array',
            'emails.*' => 'required|email',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nome',
            'description' => 'descrição',
            'emails' => 'e-mails',
            'emails.*' => 'e-mail',
        ];
    }
}
