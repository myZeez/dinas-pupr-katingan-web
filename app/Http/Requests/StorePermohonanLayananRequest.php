<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePermohonanLayananRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'nama' => [
                'required',
                'string',
                'min:3',
                'max:255'
            ],
            'nik' => [
                'required',
                'string',
                'size:16',
                'regex:/^[0-9]{16}$/'
            ],
            'email' => [
                'required',
                'email',
                'max:255'
            ],
            'telepon' => [
                'required',
                'string',
                'min:10',
                'max:15'
            ],
            'alamat' => [
                'required',
                'string',
                'min:10',
                'max:500'
            ],
            'jenis_layanan' => [
                'required',
                'string',
                Rule::in([
                    'permohonan_imb',
                    'permohonan_sbg',
                    'permohonan_rtbl',
                    'permohonan_advice_planning',
                    'permohonan_pkkpr',
                    'Surat Permohonan',
                    'Peta Lokasi',
                    'Data Teknis Bangunan/Kawasan',
                    'Dokumen Pendukung'
                ])
            ],
            'deskripsi' => [
                'required',
                'string',
                'min:20',
                'max:1000'
            ],
            'documents' => [
                'nullable',
                'array',
                'max:5'
            ],
            'documents.*' => [
                'file',
                'mimes:pdf,doc,docx,jpg,jpeg,png',
                'max:2048'
            ]
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'nama.min' => 'Nama minimal 3 karakter.',
            'nama.max' => 'Nama maksimal 255 karakter.',

            'nik.required' => 'NIK wajib diisi.',
            'nik.size' => 'NIK harus tepat 16 digit.',
            'nik.regex' => 'NIK hanya boleh berisi angka.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 255 karakter.',

            'telepon.required' => 'Nomor telepon wajib diisi.',
            'telepon.min' => 'Nomor telepon minimal 10 digit.',
            'telepon.max' => 'Nomor telepon maksimal 15 digit.',

            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.min' => 'Alamat minimal 10 karakter.',
            'alamat.max' => 'Alamat maksimal 500 karakter.',

            'jenis_layanan.required' => 'Jenis layanan wajib dipilih.',
            'jenis_layanan.in' => 'Jenis layanan tidak valid.',

            'deskripsi.required' => 'Deskripsi permohonan wajib diisi.',
            'deskripsi.min' => 'Deskripsi minimal 20 karakter.',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter.',

            'documents.array' => 'Format dokumen tidak valid.',
            'documents.max' => 'Maksimal 5 file dapat diupload.',
            'documents.*.file' => 'File harus berupa file yang valid.',
            'documents.*.mimes' => 'File harus berformat PDF, DOC, DOCX, JPG, JPEG, atau PNG.',
            'documents.*.max' => 'Ukuran file maksimal 2MB.'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'nama' => 'nama lengkap',
            'nik' => 'NIK',
            'email' => 'alamat email',
            'telepon' => 'nomor telepon',
            'alamat' => 'alamat',
            'jenis_layanan' => 'jenis layanan',
            'deskripsi' => 'deskripsi permohonan',
            'documents' => 'dokumen'
        ];
    }
}
