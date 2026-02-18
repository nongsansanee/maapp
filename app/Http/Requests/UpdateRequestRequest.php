<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequestRequest extends FormRequest
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
            // 'actor' => 'required|max:50',
            'user_id' => 'required',
            'requester' => 'required|max:50',
            'date_request' => 'required',
            'application' => 'required',
            'type_request' => 'required',
            // 'status_request' => 'required',
            'description' => 'required|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            // 'actor.required' => 'กรุณากรอกชื่อผู้กระทำ',
            'requester.required' => 'กรุณากรอกผู้ร้องขอ',
            'date_request.required' => 'กรุณากรอกวันที่',
            'application.required' => 'กรุณาเลือกแอปพลิเคชัน',
            'type_request.required' => 'กรุณาเลือกประเภทคำขอ',
            // 'status_request.required' => 'กรุณาเลือกสถานะคำขอ',
            'description.required' => 'กรุณากรอกคำอธิบาย',
        ];
    }
}
