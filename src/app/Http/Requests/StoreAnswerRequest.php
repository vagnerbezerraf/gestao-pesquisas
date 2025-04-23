<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreAnswerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.value' => 'required',
        ];
    }

    public function attributes(): array
    {
        return [
            'answers' => 'respostas',
            'answers.*.question_id' => 'id da pergunta',
            'answers.*.value' => 'valor da resposta',
        ];
    }
}
