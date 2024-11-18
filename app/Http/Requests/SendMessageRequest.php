<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use App\Models\Student;
use App\Models\Recruiter;

class SendMessageRequest extends FormRequest
{
    protected $receiver;
    
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
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'receiver_id' => 'required|exists:users,id',
        ];
    }

    public function withValidator($validator)
    {
        // After validation, resolve the receiver model
        $validator->after(function ($validator) {
            $this->receiver = User::find($this->receiver_id);

            if (!$this->receiver) {
                $validator->errors()->add('receiver_id', 'Receiver not found');
            }
        });
    }

    public function getReceiver()
    {
        return $this->receiver;
    }
}
