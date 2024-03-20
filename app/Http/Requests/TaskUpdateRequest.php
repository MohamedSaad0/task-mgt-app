<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskUpdateRequest extends FormRequest
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
            // "title"  => "required|min:10",
            "description" => "string|max:255",
            "status" => "",
            "assignee_id" => "",
            "dependency_of" => "",
            "due_date_from" => "",
            "due_date_to" => "",
        ];
    }
}
