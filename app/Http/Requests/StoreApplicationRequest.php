<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
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
            'name_th' => 'required|max:50',
            'name_en' => 'required',
            'status' => 'required',
            'application_admin' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name_th.required' => 'กรุณาระบุชื่อระบบ(ภาษาไทย)',
            'name_th.max' => 'กรุณาระบุชื่อระบบ(ภาษาไทย) ไม่เกิน 50 ตัวอักษร',
        ];
    }
}
