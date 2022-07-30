<?php

namespace App\Http\Requests\Project;

use App\Enums\Project\Status;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string|in:' . implode(',', data_get(Status::cases(), '*.value')),
            'contact_people' => 'required|array',
            'contact_people.*' => 'required|integer|exists:\App\Models\ContactPerson,id,deleted_at,NULL',
        ];
    }
}
