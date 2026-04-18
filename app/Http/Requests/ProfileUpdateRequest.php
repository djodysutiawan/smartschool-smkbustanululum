<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'   => ['required', 'string', 'max:255'],
            'email'  => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'no_hp'  => ['nullable', 'string', 'max:20'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'   => 'Nama wajib diisi.',
            'name.max'        => 'Nama maksimal 255 karakter.',
            'email.required'  => 'Email wajib diisi.',
            'email.email'     => 'Format email tidak valid.',
            'email.unique'    => 'Email sudah digunakan oleh akun lain.',
            'no_hp.max'       => 'Nomor HP maksimal 20 karakter.',
            'avatar.image'    => 'File avatar harus berupa gambar.',
            'avatar.mimes'    => 'Format avatar harus JPG, PNG, atau WebP.',
            'avatar.max'      => 'Ukuran avatar maksimal 2 MB.',
        ];
    }
}