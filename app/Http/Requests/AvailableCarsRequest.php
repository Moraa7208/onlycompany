<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvailableCarsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'model' => 'nullable|string|max:255',
            'comfort_category_id' => 'nullable|exists:comfort_categories,id',
        ];
    }

    
    public function messages(): array
    {
        return [
            'start_time.required' => 'Start time is required',
            'start_time.after' => 'Start time must be in the future',
            'end_time.after' => 'End time must be after start time',
            'comfort_category_id.exists' => 'Invalid comfort category',
        ];
    }
}
