<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
            'phone' => 'required',
            'role' => 'required',
            'address' => 'required',
            'is_active' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên người dùng không được để trống.',
            'email.required' => 'Email bắt buộc nhập.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại.',
            'password.required' => 'Mật khẩu bắt buộc nhập.',
            'password.confirmed' => 'Xác nhận mật khẩu  buộc nhập.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'phone.required' => 'Số điện thoại không được để trống.',
            'address.required' => 'Địa chỉ người dùng không được để trống.',
        ];
    }
}
