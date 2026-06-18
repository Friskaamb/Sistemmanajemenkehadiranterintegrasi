# PROJECT ANALYSIS & BACKEND IMPLEMENTATION GUIDE
## Sistem Manajemen Kehadiran Terintegrasi - PT.DFL

---

## 📊 PROJECT OVERVIEW

### Current Status
- ✅ **Frontend:** Sudah selesai (100%)
- ❌ **Backend:** Perlu dilengkapi
- ❌ **Database:** Perlu disetup

### Tech Stack
- **Framework:** Laravel 12
- **Frontend:** Blade Template + Tailwind CSS
- **Database:** MySQL
- **Authentication:** Laravel Auth

---

## 🏗️ PROJECT STRUCTURE ANALYSIS

### Frontend Pages (Sudah Ada)
```
Public Pages:
├── login.blade.php - Form login
├── register.blade.php - Form register
└── home.blade.php - Landing page

Karyawan Portal:
├── dashboard.blade.php - Dashboard karyawan
├── riwayat.blade.php - Riwayat kehadiran
├── izin.blade.php - Pengajuan izin/cuti
└── profil.blade.php - Profile management

Admin Portal:
├── dashboard.blade.php - Dashboard admin
├── karyawan.blade.php - Manajemen karyawan
├── rekap.blade.php - Rekap absensi
└── persetujuan.blade.php - Approval izin
```

### Controllers (Partial - Perlu Dilengkapi)
```
✅ LoginController - Login functionality
❌ AttendanceController - Perlu lengkapi methods export PDF/Excel
❌ LeaveController - Perlu implementasi CRUD & workflow
❌ DashboardController - Hardcoded data, perlu query dari DB
❌ ProfileController - Perlu implementasi update profile
✅ AuthController - Ada tapi not used (redundant dengan LoginController)
```

### Models (Perlu Ditambah)
```
✅ User - Ada (tapi field kurang)
✅ Attendance - Ada (field kurang)
❌ Leave - MISSING - Perlu dibuat
❌ Department - MISSING - Perlu dibuat
❌ Shift - MISSING - Perlu dibuat
❌ Holiday - MISSING - Perlu dibuat
❌ LeaveQuota - MISSING - Perlu dibuat
❌ AuditLog - MISSING - Perlu dibuat
```

### Database Migrations
```
✅ 0001_01_01_000000_create_users_table.php
❌ Perlu update: tambah field (role, nik, department_id, phone, address, etc)
✅ 0001_01_01_000001_create_cache_table.php
✅ 0001_01_01_000002_create_jobs_table.php
✅ 2026_04_14_140508_create_attendances_table.php
❌ Perlu update: tambah field (foto_masuk, foto_pulang, status, gps_status, total_jam)
❌ MISSING: leave, department, shift, leave_quota, holiday, attendance_logs, audit_logs
```

---

## 🔍 FEATURE BREAKDOWN

### 1. Authentication ✅
**Status:** Partial (Login done, but needs roles & permissions)
- [x] Login form
- [x] Logout
- [ ] Register (form ada, backend tidak)
- [ ] Password reset
- [ ] Role-based access control
- [ ] Remember me functionality

**Action Items:**
```bash
# Update LoginController untuk:
- Password reset functionality
- Email verification (optional)
- Rate limiting untuk login attempts

# Create AuthServiceProvider untuk:
- Role & permission policies
- Gate definitions
```

---

### 2. Attendance Module ✅
**Status:** Partial (Frontend done, backend perlu integration)
- [x] Frontend UI untuk checkin/checkout
- [x] Foto capture dengan webcam
- [ ] Database integration (hadir, terlambat auto-calculate)
- [ ] Attendance history view
- [ ] Reports (PDF/Excel export)
- [ ] GPS verification

**Current Implementation:**
- Attendance created di `AttendanceController@masuk()` 
- Status auto-calculated berdasarkan jam
- Foto disimpan ke `public/uploads/absensi/`

**Perlu Ditambah:**
```php
// AttendanceController methods yang masih TODO:
- export_pdf() - Export attendance ke PDF
- export_excel() - Export ke Excel
- getAttendanceByDate() - Get attendance data by date range
- getAttendanceSummary() - Summary stats per user
- getMonthlyReport() - Monthly attendance report

// Logic yang perlu ditambah:
- Validasi GPS location
- Calculate overtime
- Holiday detection
- Shift-based calculation
```

---

### 3. Leave Management ❌
**Status:** Frontend only (perlu full backend implementation)
- [x] Frontend form untuk pengajuan izin
- [x] Frontend list untuk status pengajuan
- [ ] Backend CRUD operations
- [ ] Approval workflow
- [ ] Quota management
- [ ] Auto-update sisa kuota

**Perlu Dibuat:**
```php
// Model: Leave
- Relationships dengan User
- Validation rules
- Status workflow

// Model: LeaveQuota  
- Track kuota tahunan per employee
- Update sisa kuota saat leave approved

// LeaveController - Full implementation:
- index() - List pengajuan user
- store() - Submit pengajuan baru
- show() - Detail pengajuan
- update() - Update pengajuan (sebelum diapprove)
- destroy() - Batalkan pengajuan
- approve() - Admin approve
- reject() - Admin reject

// Events & Notifications:
- LeaveRequested event
- LeaveApproved event
- LeaveRejected event
- Send email notifications
```

---

### 4. Employee Management ❌
**Status:** Frontend only (perlu backend)
- [x] Karyawan list page UI
- [ ] Search/filter functionality
- [ ] CRUD operations
- [ ] Import Excel
- [ ] Export list

**Perlu Implementasi:**
```php
// Create EmployeeController atau extend DashboardController:
- store() - Tambah karyawan baru
- update() - Edit data karyawan
- destroy() - Hapus karyawan (soft delete)
- search() - Search employees
- importExcel() - Bulk import from Excel
- exportExcel() - Export employee list

// Middleware:
- Hanya admin yang bisa manage karyawan
```

---

### 5. Dashboard ❌
**Status:** Frontend dengan hardcoded data

**Current Issue:**
```php
// DashboardController - Hardcoded values:
public function index() {
    $kehadiranBulanIni = 18; // HARDCODED - perlu query DB
    $sisaCuti = 8; // HARDCODED
    $keterlambatan = 2; // HARDCODED
}

public function admin() {
    $totalKaryawan = 247; // HARDCODED
    $hadirHariIni = 234; // HARDCODED
    $terlambat = 8; // HARDCODED
    $tidakHadir = 5; // HARDCODED
}
```

**Perlu Di-Query dari Database:**
```sql
-- Attendance bulan ini per user
SELECT COUNT(*) as kehadiran_bulan_ini,
       COUNT(CASE WHEN status='Terlambat' THEN 1 END) as keterlambatan
FROM attendances
WHERE user_id = ? AND YEAR(tanggal) = ? AND MONTH(tanggal) = ?

-- Total karyawan aktif
SELECT COUNT(*) as total FROM users WHERE status = 'aktif'

-- Hadir hari ini
SELECT COUNT(*) FROM attendances 
WHERE tanggal = CURDATE() AND status IN ('Hadir', 'Terlambat')
```

---

### 6. Profile Management ❌
**Status:** Frontend UI ada, backend TODO
- [x] Profile page UI
- [ ] Update profile
- [ ] Change password
- [ ] Update photo

**Perlu Implementasi:**
```php
// ProfileController:
public function update(Request $request) {
    // Validate: name, phone, address, email
    // Update photo jika ada
    // Update password jika ada
    // Return success message
}

public function changePassword(Request $request) {
    // Validate old password
    // Hash new password
    // Update di database
}
```

---

## 🗄️ DATABASE SCHEMA YANG SUDAH DIBUAT

File: `database.sql` (sudah ada di root folder)

**Tabel yang Sudah Dirancang:**
1. ✅ departments - Divisi/Departemen
2. ✅ users - Pengguna (updated dengan field lengkap)
3. ✅ attendances - Absensi (updated dengan field lengkap)
4. ✅ leaves - Pengajuan izin/cuti
5. ✅ leave_quotas - Kuota cuti tahunan
6. ✅ shifts - Jadwal kerja
7. ✅ user_shifts - Penugasan shift
8. ✅ attendance_logs - Log detail absensi
9. ✅ holidays - Hari libur
10. ✅ audit_logs - Audit trail

**Sample Data:**
- 1 Admin user
- 6 Sample employees
- Sample departments
- Sample shifts
- Sample attendance records
- Sample leave requests
- 10 Public holidays 2026

---

## 📋 IMPLEMENTATION CHECKLIST

### Phase 1: Database Setup ✅
- [x] Design database schema
- [x] Create SQL file with migrations
- [ ] Import database ke MySQL
- [ ] Verify tabel & relationships

### Phase 2: Update Laravel Models
- [ ] Update User model (add fields & relationships)
- [ ] Update Attendance model (add relationships)
- [ ] Create Leave model
- [ ] Create Department model
- [ ] Create Shift model
- [ ] Create Holiday model
- [ ] Create LeaveQuota model
- [ ] Create AuditLog model

### Phase 3: Create Migrations
- [ ] Update create_users_table migration
- [ ] Update create_attendances_table migration
- [ ] Create new migrations untuk tabel baru

### Phase 4: Backend Implementation
- [ ] Update AttendanceController (query DB, export PDF/Excel)
- [ ] Create/Update LeaveController (full CRUD & approval)
- [ ] Create/Update EmployeeController (CRUD, import/export)
- [ ] Update DashboardController (query actual data)
- [ ] Update ProfileController (update profile)
- [ ] Create ReportController (reports & analytics)

### Phase 5: API Endpoints (Optional but Recommended)
- [ ] Create API routes
- [ ] Implement REST endpoints untuk mobile app (future)
- [ ] API authentication dengan Sanctum
- [ ] API documentation (OpenAPI/Swagger)

### Phase 6: Middleware & Validation
- [ ] Create role-based middleware (AdminMiddleware, ManagerMiddleware)
- [ ] Validation rules di setiap controller
- [ ] Error handling & custom exceptions

### Phase 7: Testing & Deployment
- [ ] Unit tests untuk models
- [ ] Feature tests untuk controllers
- [ ] Database seeding untuk testing
- [ ] Deploy ke production

---

## 🔧 QUICK START GUIDE

### 1. Import Database
```bash
# Via MySQL command line
mysql -u root -p < database.sql

# Atau via phpMyAdmin
# Import file database.sql di phpMyAdmin
```

### 2. Update .env
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_kehadiran_db
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Run Migrations (Jika Menggunakan Laravel Migration)
```bash
php artisan migrate
```

### 4. Create Models
```bash
php artisan make:model Leave -m
php artisan make:model Department -m
php artisan make:model Shift -m
# ... etc
```

### 5. Update Relationships
```php
// User model
public function attendances() {
    return $this->hasMany(Attendance::class);
}

public function leaves() {
    return $this->hasMany(Leave::class);
}

// Attendance model
public function user() {
    return $this->belongsTo(User::class);
}

// Leave model
public function user() {
    return $this->belongsTo(User::class);
}

public function approver() {
    return $this->belongsTo(User::class, 'approved_by');
}
```

---

## 🚀 NEXT STEPS FOR YOUR TEAM

1. **Import database.sql ke MySQL**
   ```bash
   mysql -u root -p sistem_kehadiran_db < database.sql
   ```

2. **Verify koneksi di .env**
   ```bash
   php artisan tinker
   >>> User::count(); // should return > 0
   ```

3. **Start implementing models & controllers sesuai checklist**

4. **Test setiap fitur secara incremental**

5. **Dokumentasikan API endpoints**

---

## 📞 FILE REFERENCES

Files yang sudah dibuat:
- `database.sql` - SQL schema lengkap dengan sample data
- `DATABASE_SCHEMA.md` - Dokumentasi lengkap tabel & relationships
- `PROJECT_ANALYSIS.md` - File ini

---

## 🎯 TIPS IMPLEMENTASI

1. **Gunakan model relationships** - Jangan raw queries
2. **Implement scopes** - Untuk reusable query filters
   ```php
   // User model
   public function scopeActive($query) {
       return $query->where('status', 'aktif');
   }
   
   // Usage
   User::active()->count();
   ```

3. **Use events & listeners** - Untuk approval workflow
   ```php
   event(new LeaveRequested($leave));
   event(new LeaveApproved($leave));
   ```

4. **Implement audit logging** - Track semua perubahan
5. **Use transactions** - Untuk data integrity saat update kuota
6. **Implement soft deletes** - Untuk history tracking
7. **Use timestamps** - created_at & updated_at sudah di schema

---

## 💡 ADDITIONAL RECOMMENDATIONS

### Security
- [ ] Implement rate limiting untuk login
- [ ] CSRF protection (sudah default di Laravel)
- [ ] SQL injection protection (gunakan Eloquent)
- [ ] File upload validation
- [ ] Password hashing (sudah ada Hash facade)

### Performance
- [ ] Add indexes (sudah di schema)
- [ ] Implement caching untuk dashboard
- [ ] Lazy loading prevention
- [ ] Query optimization

### Features to Consider (Future)
- [ ] Mobile app (React Native/Flutter)
- [ ] WhatsApp notification integration
- [ ] SMS alerts untuk terlambat
- [ ] Biometric fingerprint scanning
- [ ] Real-time notifications
- [ ] Two-factor authentication
- [ ] Self-service leave balance inquiry

---

**Created:** 2026-06-17
**Last Updated:** 2026-06-17
**Status:** Ready for Implementation
