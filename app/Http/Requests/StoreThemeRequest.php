<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreThemeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin() || $this->user()->isCdc();
    }

    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255|unique:themes,title',
            'description' => 'nullable|string',
            'duration'    => 'required|string|max:255',
            'formation_id' => 'required|exists:formations,id',
        ];
    }
}
