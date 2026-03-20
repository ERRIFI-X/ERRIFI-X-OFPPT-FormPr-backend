<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAbsenceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin() || $this->user()->isCdc() || $this->user()->isFormateur();
    }

    public function rules(): array
    {
        return [
            'participant_id' => 'required|exists:participants,id',
            'session_id'     => 'required|exists:sessions,id',
            'date'           => 'required|date',
            'reason'         => 'nullable|string|max:500',
        ];
    }
}
