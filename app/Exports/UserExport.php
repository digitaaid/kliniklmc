<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::get([
            'id',
            'name',
            'phone',
            'email',
            'username',
            'google_id',
            'avatar',
            'avatar_original',
            'password',
            'email_verified_at',
            'user_verify',
            'created_at',
            'updated_at',
        ]);
    }
    public function headings(): array
    {
        return [
            'id',
            'name',
            'phone',
            'email',
            'username',
            'google_id',
            'avatar',
            'avatar_original',
            'password',
            'email_verified_at',
            'user_verify',
            'created_at',
            'updated_at',
        ];
    }
}
