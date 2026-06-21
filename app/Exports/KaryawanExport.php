<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KaryawanExport implements FromCollection, WithHeadings
{
    protected $search;
    protected $division;

    public function __construct($search, $division)
    {
        $this->search = $search;
        $this->division = $division;
    }

    public function collection()
    {
        return User::with('division')
            ->where('role', '!=', 'admin')

            ->when($this->search, function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('nik', 'like', "%{$this->search}%");
            })

            ->when($this->division, function ($q) {
                $q->where('division_id', $this->division);
            })

            ->get()
            ->map(function ($user) {
                return [
                    'Nama' => $user->name,
                    'NIK' => $user->nik,
                    'Email' => $user->email,
                    'Divisi' => $user->division->nama_divisi ?? '-',
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