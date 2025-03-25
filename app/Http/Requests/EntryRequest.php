<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'organization' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'type' => 'required|in:experience,volunteering,education',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'current' => 'boolean',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
