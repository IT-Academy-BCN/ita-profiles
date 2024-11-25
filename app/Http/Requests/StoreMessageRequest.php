<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use App\Models\Student;
use App\Models\Recruiter;
use Illuminate\Support\Facades\Auth;

class StoreMessageRequest extends FormRequest
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
            'receiver_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ];
    }

    public function messages()
{
    return [
        'receiver_id.required' => 'The receiver ID is required.',
        'receiver_id.exists' => 'The specified receiver does not exist.',
        'subject.required' => 'A subject is required.',
        'body.required' => 'The message body cannot be empty.',
    ];
}


}