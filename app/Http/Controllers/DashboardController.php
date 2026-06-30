<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Leave;
use App\Models\Division;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Exports\KaryawanExport;
use Maatwebsite\Excel\Facades\Excel;


class DashboardController extends Controller
{
   public function index()
{
    $absenHariIni = Attendance::where('user_id', Auth::id())
        ->whereDate('tanggal', today())
        ->first();

    $hadirBulanIni = Attendance::where('user_id', Auth::id())
        ->whereMonth('tanggal', now()->month)
        ->count();

    $terlambatBulanIni = Attendance::where('user_id', Auth::id())
        ->whereMonth('tanggal', now()->month)
        ->where('status', 'Terlambat')
        ->count();

    return view('karyawan.dashboard', compact(
        'absenHariIni',
        'hadirBulanIni',
        'terlambatBulanIni'
    ));
}


    public function admin()
{
    $totalKaryawan = User::where('role', 'karyawan')->count();

    $hadirHariIni = Attendance::whereDate('tanggal',today())->count();

    $terlambat = Attendance::whereDate('tanggal',today())
    ->where('status', 'Terlambat')
    ->count();

    $tidakHadir = max(0,$totalKaryawan - $hadirHariIni);
    $absensiTerbaru = Attendance::latest()
    ->take(10)
    ->get();
    $cutiPending = Leave::where('status', 'Pending')->count();

    $divisions = Division::withCount('users')->get();
    $topTerlambat = Attendance::select(
        'nama',
        DB::raw('COUNT(*) as total')
    )
    ->where('status', 'Terlambat')
    ->whereDate('tanggal', '>=', now()->subDays(30))
    ->groupBy('nama')
    ->orderByDesc('total')
    ->limit(5)
    ->get();
    return view('admin.dashboard', compact(
    'totalKaryawan',
    'hadirHariIni',
    'terlambat',
    'tidakHadir',
    'absensiTerbaru',
    'divisions',
    'cutiPending',
    'topTerlambat'
    
));
}

   public function data_karyawan(Request $request)
{
    $search = $request->search;
    $division = $request->division;

    $karyawans = User::with('division')
        ->where('role', '!=', 'admin')

        ->when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
        })

        ->when($division, function ($query) use ($division) {
            $query->where('division_id', $division);
        }) 
        ->paginate(10);

    $divisions = Division::all();

    return view(
        'admin.karyawan',
        compact('karyawans', 'divisions')
    );
}

public function create_karyawan()
{
    $divisions = Division::all();

    return view('admin.tambah_karyawan', compact('divisions'));
}

public function storekaryawan(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'nik' => 'required|unique:users,nik',
        'division_id' => 'required',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'nik' => $request->nik,
        'division_id' => $request->division_id,
        'password' => Hash::make('12345678'),
        'role' => 'karyawan',
    ]);

    return redirect()
    ->route('admin.karyawan')
    ->with('success', 'Karyawan berhasil ditambahkan');}

    public function destroyKaryawan($id)
{
    $karyawan = User::findOrFail($id);

    $karyawan->delete();

    return redirect()
        ->route('admin.karyawan')
        ->with('success', 'Karyawan berhasil dihapus');
}

public function editKaryawan($id)
{
    $karyawan = User::findOrFail($id);
    $divisions = Division::all();

    return view('admin.edit_karyawan', compact(
        'karyawan',
        'divisions'
    ));
}

public function updateKaryawan(Request $request, $id)
{
    $karyawan = User::findOrFail($id);

    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'nik' => 'required',
        'division_id' => 'required'
    ]);

    $karyawan->update([
        'name' => $request->name,
        'email' => $request->email,
        'nik' => $request->nik,
        'division_id' => $request->division_id,
    ]);

    return redirect()
        ->route('admin.karyawan')
        ->with('success', 'Data karyawan berhasil diperbarui');
}


public function exportKaryawan(Request $request)
{
    return Excel::download(
        new KaryawanExport(
            $request->search,
            $request->division
        ),
        'data_karyawan.xlsx'
    );
}

public function rekap(Request $request)
{
    $tanggal = $request->tanggal;
    $status = $request->status;

    $data = Attendance::with('user')

        ->when($tanggal, function ($query) use ($tanggal) {
            $query->whereDate('tanggal', $tanggal);
        })

        ->when($status, function ($query) use ($status) {
            $query->where('status', $status);
        })

        ->orderBy('tanggal', 'desc')
        ->get();

    return view('admin.rekap', compact('data'));
}
}