<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'text' => 'required|string',
            'type' => 'required|string',
            'options' => 'nullable|array',
            'weight' => 'required|integer',
            'question_group_id' => 'required|exists:question_groups,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'text' => 'texto',
            'type' => 'tipo',
            'options' => 'opções',
            'weight' => 'peso',
            'question_group_id' => 'grupo de perguntas',
        ];
    }
}
