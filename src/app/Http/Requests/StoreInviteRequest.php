<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreInviteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'survey_id' => 'required|exists:surveys,id',
            'group_id' => 'required|exists:groups,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'survey_id' => 'id da pesquisa',
            'group_id' => 'id do grupo',
        ];
    }
}
