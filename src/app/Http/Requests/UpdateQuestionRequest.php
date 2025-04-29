<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'text' => 'sometimes|required|string',
            'type' => 'sometimes|required|string',
            'options' => 'nullable|array',
            'weight' => 'sometimes|required|integer',
            'question_category_id' => 'sometimes|required|exists:question_categories,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'text' => 'texto',
            'type' => 'tipo',
            'options' => 'opções',
            'weight' => 'peso',
            'question_category_id' => 'categoria de perguntas',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('options') && is_string($this->options)) {
            $opts = array_filter(array_map('trim', explode(',', $this->options)));
            $this->merge(['options' => $opts]);
        }
    }
}
