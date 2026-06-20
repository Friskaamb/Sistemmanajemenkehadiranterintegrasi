<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KaryawanExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::with('division')
            ->where('role', '!=', 'admin')
            ->get()
            ->map(function ($user) {
                return [
                    $user->name,
                    $user->nik,
                    $user->email,
                    $user->division->nama_divisi ?? '-',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama',
            'NIK',
            'Email',
            'Divisi'
        ];
    }
}