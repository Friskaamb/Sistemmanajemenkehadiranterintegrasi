// Laravel Migration Files untuk menciptakan/update tabel
// Copy-paste ke file migration yang bersesuaian

// ============================================================================
// FILE: database/migrations/TIMESTAMP_update_users_table.php
// ============================================================================
// Jalankan: php artisan make:migration update_users_table
// Kemudian copy paste code di bawah ke file yang baru dibuat

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambah kolom baru jika belum ada
            if (!Schema::hasColumn('users', 'nik')) {
                $table->string('nik', 50)->unique()->after('password')->comment('Nomor Identitas Karyawan');
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'karyawan', 'manager'])->default('karyawan')->after('nik');
            }
            if (!Schema::hasColumn('users', 'department_id')) {
                $table->unsignedBigInteger('department_id')->nullable()->after('role');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 20)->nullable()->after('department_id');
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'photo')) {
                $table->string('photo')->nullable()->after('address')->comment('Path foto profil');
            }
            if (!Schema::hasColumn('users', 'hire_date')) {
                $table->date('hire_date')->nullable()->after('photo')->comment('Tanggal bergabung');
            }
            if (!Schema::hasColumn('users', 'status')) {
                $table->enum('status', ['aktif', 'nonaktif', 'cuti', 'resign'])->default('aktif')->after('hire_date');
            }

            // Add indexes
            $table->index('role');
            $table->index(['department_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nik', 'role', 'department_id', 'phone', 'address', 'photo', 'hire_date', 'status'
            ]);
        });
    }
};


// ============================================================================
// FILE: database/migrations/TIMESTAMP_update_attendances_table.php
// ============================================================================

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Tambah foreign key ke users
            if (!Schema::hasColumn('attendances', 'user_id')) {
                $table->unsignedBigInteger('user_id')->after('id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }

            // Tambah kolom yang kurang
            if (!Schema::hasColumn('attendances', 'foto_masuk')) {
                $table->string('foto_masuk')->nullable()->after('jam_pulang')->comment('Path foto absen masuk');
            }
            if (!Schema::hasColumn('attendances', 'foto_pulang')) {
                $table->string('foto_pulang')->nullable()->after('foto_masuk')->comment('Path foto absen pulang');
            }
            if (!Schema::hasColumn('attendances', 'status')) {
                $table->enum('status', ['Hadir', 'Terlambat', 'Izin', 'Sakit', 'Cuti', 'Libur', 'Tidak Hadir'])
                    ->default('Hadir')->after('foto_pulang');
            }
            if (!Schema::hasColumn('attendances', 'gps_status')) {
                $table->string('gps_status', 50)->nullable()->after('status')->comment('Verified, Unverified, Out of Range');
            }
            if (!Schema::hasColumn('attendances', 'total_jam')) {
                $table->decimal('total_jam', 5, 2)->nullable()->after('gps_status')->comment('Total jam kerja');
            }
            if (!Schema::hasColumn('attendances', 'catatan')) {
                $table->text('catatan')->nullable()->after('total_jam');
            }

            // Add unique constraint
            $table->unique(['user_id', 'tanggal']);

            // Add indexes
            $table->index('status');
            $table->index(['user_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn([
                'user_id', 'foto_masuk', 'foto_pulang', 'status', 'gps_status', 'total_jam', 'catatan'
            ]);
            $table->dropUnique(['user_id', 'tanggal']);
            $table->dropIndex(['user_id', 'tanggal']);
        });
    }
};


// ============================================================================
// FILE: database/migrations/TIMESTAMP_create_departments_table.php
// ============================================================================

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->text('deskripsi')->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->timestamps();
            $table->unique('nama');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};


// ============================================================================
// FILE: database/migrations/TIMESTAMP_create_leaves_table.php
// ============================================================================

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('jenis_izin', [
                'Cuti Tahunan',
                'Sakit',
                'Izin Pribadi',
                'Izin Pernikahan',
                'Kematian',
                'Cuti Bersama'
            ]);
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->text('alasan');
            $table->string('lampiran')->nullable()->comment('Path file lampiran');
            $table->enum('status', ['Pending', 'Disetujui', 'Ditolak', 'Dibatalkan'])->default('Pending');
            $table->unsignedBigInteger('approved_by')->nullable()->comment('User ID yang approve');
            $table->timestamp('approval_date')->nullable();
            $table->text('catatan_persetujuan')->nullable();
            $table->integer('jumlah_hari')->comment('Total hari izin');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');

            $table->index('user_id');
            $table->index('status');
            $table->index('tgl_mulai');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};


// ============================================================================
// FILE: database/migrations/TIMESTAMP_create_leave_quotas_table.php
// ============================================================================

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leave_quotas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->year('tahun');
            $table->integer('kuota_cuti_tahunan')->default(12);
            $table->integer('kuota_sakit')->default(12);
            $table->integer('kuota_izin_pribadi')->default(3);
            $table->integer('sisa_cuti_tahunan')->default(12);
            $table->integer('sisa_sakit')->default(12);
            $table->integer('sisa_izin_pribadi')->default(3);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['user_id', 'tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leave_quotas');
    }
};


// ============================================================================
// FILE: database/migrations/TIMESTAMP_create_shifts_table.php
// ============================================================================

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->time('jam_masuk');
            $table->time('jam_pulang');
            $table->integer('toleransi_terlambat')->default(15)->comment('Menit toleransi');
            $table->boolean('aktif')->default(true);
            $table->timestamps();

            $table->unique('nama');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};


// ============================================================================
// FILE: database/migrations/TIMESTAMP_create_user_shifts_table.php
// ============================================================================

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_shifts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('shift_id');
            $table->date('tgl_berlaku');
            $table->date('tgl_berakhir')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('cascade');

            $table->index('user_id');
            $table->index('shift_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_shifts');
    }
};


// ============================================================================
// FILE: database/migrations/TIMESTAMP_create_attendance_logs_table.php
// ============================================================================

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('tanggal');
            $table->time('jam');
            $table->enum('tipe', ['masuk', 'pulang']);
            $table->decimal('latitude', 10, 8)->nullable()->comment('Koordinat GPS');
            $table->decimal('longitude', 11, 8)->nullable()->comment('Koordinat GPS');
            $table->integer('accuracy')->nullable()->comment('Akurasi GPS dalam meter');
            $table->string('foto')->nullable();
            $table->string('device_info', 255)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('user_id');
            $table->index('tanggal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_logs');
    }
};


// ============================================================================
// FILE: database/migrations/TIMESTAMP_create_holidays_table.php
// ============================================================================

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('holidays', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->date('tanggal')->unique();
            $table->enum('tipe', ['Nasional', 'Perusahaan', 'Regional']);
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->index('tanggal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('holidays');
    }
};


// ============================================================================
// FILE: database/migrations/TIMESTAMP_create_audit_logs_table.php
// ============================================================================

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('aksi', 255);
            $table->string('tabel', 100);
            $table->json('data_lama')->nullable();
            $table->json('data_baru')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('user_id');
            $table->index('tabel');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};


// ============================================================================
// SEEDER FILE: database/seeders/DefaultDataSeeder.php
// ============================================================================

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;
use App\Models\Shift;
use App\Models\Holiday;
use App\Models\LeaveQuota;
use App\Models\Attendance;
use App\Models\Leave;
use Illuminate\Support\Facades\Hash;

class DefaultDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Departments
        $dept_eng = Department::create(['nama' => 'Engineering', 'deskripsi' => 'Departemen Engineering/Teknis']);
        $dept_mkt = Department::create(['nama' => 'Marketing', 'deskripsi' => 'Departemen Marketing/Pemasaran']);
        $dept_hr = Department::create(['nama' => 'HR', 'deskripsi' => 'Departemen Human Resources']);
        $dept_fin = Department::create(['nama' => 'Finance', 'deskripsi' => 'Departemen Keuangan']);
        $dept_ops = Department::create(['nama' => 'Operations', 'deskripsi' => 'Departemen Operasional']);

        // 2. Create Shifts
        Shift::create([
            'nama' => 'Shift Pagi',
            'jam_masuk' => '08:00:00',
            'jam_pulang' => '17:00:00',
            'toleransi_terlambat' => 15
        ]);
        Shift::create([
            'nama' => 'Shift Siang',
            'jam_masuk' => '12:00:00',
            'jam_pulang' => '21:00:00',
            'toleransi_terlambat' => 15
        ]);
        Shift::create([
            'nama' => 'Shift Malam',
            'jam_masuk' => '21:00:00',
            'jam_pulang' => '06:00:00',
            'toleransi_terlambat' => 15
        ]);

        // 3. Create Admin User
        $admin = User::create([
            'name' => 'Admin PT.DFL',
            'email' => 'admin@ptdfl.com',
            'password' => Hash::make('password'),
            'nik' => 'ADM-2024-001',
            'role' => 'admin',
            'department_id' => $dept_hr->id,
            'phone' => '081234567890',
            'hire_date' => now()->subYear(),
            'status' => 'aktif'
        ]);

        // 4. Create Sample Employees
        $employees = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@ptdfl.com',
                'nik' => 'EMP-2024-015',
                'department_id' => $dept_eng->id,
                'phone' => '081234567891'
            ],
            [
                'name' => 'Ani Wijaya',
                'email' => 'ani@ptdfl.com',
                'nik' => 'EMP-2024-032',
                'department_id' => $dept_mkt->id,
                'phone' => '081234567892'
            ],
            [
                'name' => 'Rudi Hartono',
                'email' => 'rudi@ptdfl.com',
                'nik' => 'EMP-2024-048',
                'department_id' => $dept_hr->id,
                'phone' => '081234567893'
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah@ptdfl.com',
                'nik' => 'EMP-2024-001',
                'department_id' => $dept_eng->id,
                'phone' => '081234567894'
            ],
            [
                'name' => 'David Kim',
                'email' => 'david@ptdfl.com',
                'nik' => 'EMP-2024-002',
                'department_id' => $dept_mkt->id,
                'phone' => '081234567895'
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'michael@ptdfl.com',
                'nik' => 'EMP-2024-003',
                'department_id' => $dept_hr->id,
                'phone' => '081234567896'
            ]
        ];

        foreach ($employees as $emp) {
            User::create([
                ...$emp,
                'password' => Hash::make('password'),
                'role' => 'karyawan',
                'hire_date' => now()->subMonths(rand(1, 6)),
                'status' => 'aktif'
            ]);
        }

        // 5. Create Leave Quotas
        User::where('role', 'karyawan')->each(function ($user) {
            LeaveQuota::create([
                'user_id' => $user->id,
                'tahun' => now()->year,
                'kuota_cuti_tahunan' => 12,
                'kuota_sakit' => 12,
                'kuota_izin_pribadi' => 3,
                'sisa_cuti_tahunan' => rand(8, 12),
                'sisa_sakit' => rand(10, 12),
                'sisa_izin_pribadi' => rand(2, 3)
            ]);
        });

        // 6. Create Holidays 2026
        $holidays = [
            ['nama' => 'Tahun Baru', 'tanggal' => '2026-01-01', 'tipe' => 'Nasional'],
            ['nama' => 'Isra dan Miraj', 'tanggal' => '2026-02-08', 'tipe' => 'Nasional'],
            ['nama' => 'Hari Raya Idul Fitri', 'tanggal' => '2026-04-10', 'tipe' => 'Nasional'],
            ['nama' => 'Hari Raya Idul Adha', 'tanggal' => '2026-06-06', 'tipe' => 'Nasional'],
            ['nama' => 'Hari Kemerdekaan RI', 'tanggal' => '2026-08-17', 'tipe' => 'Nasional'],
            ['nama' => 'Hari Natal', 'tanggal' => '2026-12-25', 'tipe' => 'Nasional'],
        ];

        foreach ($holidays as $holiday) {
            Holiday::create($holiday);
        }

        $this->command->info('✅ Default data seeded successfully!');
    }
}

// Jalankan dengan: php artisan db:seed --class=DefaultDataSeeder
