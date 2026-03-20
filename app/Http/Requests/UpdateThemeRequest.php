<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateThemeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin() || $this->user()->isCdc();
    }

    public function rules(): array
    {
        return [
            'title'       => 'sometimes|required|string|max:255|unique:themes,title,' . $this->route('theme')->id,
            'description' => 'nullable|string',
            'duration'    => 'sometimes|required|string|max:255',
            'formation_id' => 'sometimes|required|exists:formations,id',
        ];
    }
}
