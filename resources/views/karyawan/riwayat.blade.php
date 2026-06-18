@extends('layouts.app')

@section('content')
<div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
    <h2 class="text-2xl font-bold text-blue-900 mb-1 leading-none">Riwayat Kehadiran</h2>
    <p class="text-gray-400 text-sm italic mb-8">5 hari terakhir</p>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-gray-400 uppercase text-xs font-bold border-b">
                    <th class="pb-4">Tanggal</th>
                    <th class="pb-4">Jam Masuk</th>
                    <th class="pb-4">Jam Pulang</th>
                    <th class="pb-4">Total Jam</th>
                    <th class="pb-4">Status</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
    @forelse($attendances as $attendance)
    <tr class="border-b">
        <td class="py-5 font-medium">
            {{ \Carbon\Carbon::parse($attendance->tanggal)->translatedFormat('d F Y') }}
        </td>

        <td>{{ $attendance->jam_masuk ?? '-' }}</td>

        <td>{{ $attendance->jam_pulang ?? '-' }}</td>

        <td>{{ $attendance->total_jam ?? '-' }}</td>

        <td>
            @if($attendance->status == 'Hadir')
                <span class="bg-green-100 text-green-600 px-4 py-1 rounded-full text-xs font-bold">
                    Hadir
                </span>
            @elseif($attendance->status == 'Terlambat')
                <span class="bg-orange-100 text-orange-600 px-4 py-1 rounded-full text-xs font-bold">
                    Terlambat
                </span>
            @else
                <span class="bg-gray-100 text-gray-600 px-4 py-1 rounded-full text-xs font-bold">
                    {{ $attendance->status }}
                </span>
            @endif
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="5" class="text-center py-5 text-gray-400">
            Belum ada data absensi
        </td>
    </tr>
    @endforelse
</tbody>
        </table>
    </div>
</div>
@endsection