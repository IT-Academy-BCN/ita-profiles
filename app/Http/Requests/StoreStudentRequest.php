<?php

namespace App\Http\Requests;

class StoreStudentRequest extends UserRequest
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
        $array = [
            'subtitle' => 'required|string',
            'bootcamp' => 'required|in:Front end Developer,PHP Developer,Java Developer,Nodejs Developer',
            //endDate?
        ];

        return array_merge(parent::rules(), $array);
    }
}
