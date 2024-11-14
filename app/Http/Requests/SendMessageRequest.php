<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use App\Models\Student;
use App\Models\Recruiter;

class SendMessageRequest extends FormRequest
{
    protected $receiver; // Stores the resolved receiver model
    
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
            'receiver_id' => 'required|uuid',
            'receiver_type' => 'required|string|in:user,student,recruiter',
        ];
    }

    public function withValidator($validator)
    {
        // After validation, resolve the receiver model
        $validator->after(function ($validator) {
            $receiverClass = $this->getReceiverClass($this->receiver_type);
            if (!$receiverClass) {
                $validator->errors()->add('receiver_type', 'Invalid receiver type');
                return;
            }

            $this->receiver = $receiverClass::find($this->receiver_id);

            if (!$this->receiver) {
                $validator->errors()->add('receiver_id', 'Receiver not found');
            }
        });
    }

    public function getReceiver()
    {
        return $this->receiver;
    }

    private function getReceiverClass(string $type): ?string
    {
        return match ($type) {
            'user' => User::class,
            'student' => Student::class,
            'recruiter' => Recruiter::class,
            default => null,
        };
    }
}
