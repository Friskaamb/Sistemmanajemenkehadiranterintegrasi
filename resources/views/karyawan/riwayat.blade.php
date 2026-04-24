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
                <tr class="border-b">
                    <td class="py-5 font-medium">22 April 2026</td>
                    <td>08:30</td>
                    <td>17:15</td>
                    <td>8.75</td>
                    <td><span class="bg-green-100 text-green-600 px-4 py-1 rounded-full text-xs font-bold">Hadir</span></td>
                </tr>
                <tr class="border-b">
                    <td class="py-5 font-medium">21 April 2026</td>
                    <td>08:45</td>
                    <td>17:30</td>
                    <td>8.75</td>
                    <td><span class="bg-green-100 text-green-600 px-4 py-1 rounded-full text-xs font-bold">Hadir</span></td>
                </tr>
                <tr class="border-b">
                    <td class="py-5 font-medium text-orange-500 italic">20 April 2026</td>
                    <td>09:15</td>
                    <td>17:20</td>
                    <td>8.08</td>
                    <td><span class="bg-orange-100 text-orange-600 px-4 py-1 rounded-full text-xs font-bold">Terlambat</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection