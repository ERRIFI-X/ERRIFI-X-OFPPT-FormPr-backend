<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin() || $this->user()->isCdc();
    }

    public function rules(): array
    {
        return [
            'formation_id' => 'required|exists:formations,id',
            'theme_id'     => 'required|exists:themes,id',
            'title'        => 'required|string|max:255',
            'date'         => 'required|date',
            'start_time'   => 'required|date_format:H:i',
            'end_time'     => 'required|date_format:H:i|after:start_time',
            'location'     => 'nullable|string|max:255',
        ];
    }
}
