<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;

class RekapExport implements FromArray, WithHeadings
{
    protected $tanggal;
    protected $status;

    public function __construct($tanggal, $status)
    {
        $this->tanggal = $tanggal;
        $this->status = $status;
    }
public function array(): array
{
    return Attendance::with('user')

        ->when($this->tanggal, function ($query) {
            $query->whereDate('tanggal', $this->tanggal);
        })

        ->when($this->status, function ($query) {
            $query->where('status', $this->status);
        })

        ->get()

        ->map(function ($item) {
            return [
                $item->tanggal,
                $item->user->name ?? '-',
                $item->user->nik ?? '-',
                $item->jam_masuk,
                $item->jam_pulang,
                $item->status,
            ];
        })

        ->toArray();
}
public function headings(): array
{
    return [
        'Tanggal',
        'Nama Karyawan',
        'NIK',
        'Jam Masuk',
        'Jam Pulang',
        'Status',
    ];
}

}