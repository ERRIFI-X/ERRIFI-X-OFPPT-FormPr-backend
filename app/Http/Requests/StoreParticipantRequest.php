<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreParticipantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin() || $this->user()->isCdc();
    }

    public function rules(): array
    {
        return [
            'theme_id' => 'required|exists:themes,id',
            'user_id'  => 'required|exists:users,id|unique:participants,user_id,NULL,id,theme_id,' . $this->input('theme_id'),
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.unique' => 'This user is already a participant in this theme.',
        ];
    }
}
