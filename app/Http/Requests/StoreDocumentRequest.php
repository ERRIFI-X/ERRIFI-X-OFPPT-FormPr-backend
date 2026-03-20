<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin() || $this->user()->isCdc() || $this->user()->isFormateur();
    }

    public function rules(): array
    {
        return [
            'formation_id' => 'required|exists:formations,id',
            'title'        => 'required|string|max:255',
            'file'         => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:20480',
        ];
    }
}
