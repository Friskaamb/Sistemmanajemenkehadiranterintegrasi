# 🚀 QUICK SETUP GUIDE - SISTEM MANAJEMEN KEHADIRAN

## 📌 Ringkasan Project

Ini adalah **Sistem Manajemen Kehadiran (Attendance Management System)** untuk PT.DFL yang sudah selesai frontend-nya. Sekarang kita perlu setup database dan melengkapi backend.

---

## 🗄️ FILES YANG SUDAH SAYA BUAT

1. **database.sql** (1000+ lines)
   - Database schema lengkap dengan semua tabel
   - Sample data (admin user, 6 karyawan, departments, shifts, holidays, etc)
   - Views untuk reporting
   - Indexes untuk performance
   - Siap di-import langsung ke MySQL

2. **DATABASE_SCHEMA.md**
   - Dokumentasi lengkap setiap tabel
   - Relasi antar tabel
   - Field-field & data types
   - Sample queries

3. **PROJECT_ANALYSIS.md**
   - Analysis lengkap tentang project
   - Status setiap fitur (yang sudah done, yang perlu dibangun)
   - Implementation checklist
   - Tips & best practices

4. **LARAVEL_MIGRATIONS.md**
   - Migration files dalam format Laravel
   - Seeder untuk sample data
   - Copy-paste ready

---

## ⚡ STEP-BY-STEP SETUP

### Step 1: Import Database (Pilih Salah Satu)

#### Option A: Via MySQL Command Line (RECOMMENDED)
```bash
# Navigate ke project folder
cd C:\Laragon\WWW\Sistemmanajemenkehadiranterintegrasi

# Import database
mysql -u root -p < database.sql

# Ketika diminta password, tinggal tekan Enter (Laragon default: kosong)
```

#### Option B: Via phpMyAdmin
1. Buka phpMyAdmin (biasanya http://localhost/phpmyadmin)
2. Klik "Import"
3. Pilih file `database.sql`
4. Klik "Import"

#### Option C: Via Laragon UI
1. Buka Laragon
2. Klik kanan → MySQL → MySQL Console
3. Jalankan:
```sql
CREATE DATABASE sistem_kehadiran_db DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sistem_kehadiran_db;
-- Copy-paste semua SQL dari database.sql
```

### Step 2: Verify Database Connection

```bash
# Buka terminal di project folder
cd C:\Laragon\WWW\Sistemmanajemenkehadiranterintegrasi

# Test dengan PHP Artisan
php artisan tinker

# Jalankan command di Tinker:
>>> User::count()
# Output: 7 (1 admin + 6 karyawan)

>>> Department::count()
# Output: 5

# Keluar dari Tinker
>>> exit
```

### Step 3: Update .env File

Edit file `.env` di root project:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_kehadiran_db
DB_USERNAME=root
DB_PASSWORD=
```

### Step 4: Clear Cache (Optional tapi recommended)

```bash
php artisan config:clear
php artisan cache:clear
```

### Step 5: Test Login

1. Buka project di browser: http://localhost/Sistemmanajemenkehadiranterintegrasi/
2. Login dengan:
   - **Email:** admin@ptdfl.com
   - **Password:** password

---

## 📝 Test Users (Semua password: `password`)

### Admin
- Email: **admin@ptdfl.com**
- Role: admin
- Department: HR

### Karyawan
- Email: **budi@ptdfl.com** (Engineering)
- Email: **ani@ptdfl.com** (Marketing)
- Email: **rudi@ptdfl.com** (HR)
- Email: **sarah@ptdfl.com** (Engineering)
- Email: **david@ptdfl.com** (Marketing)
- Email: **michael@ptdfl.com** (HR)

---

## ✅ Database Schema Overview

### Main Tables (14 Tabel)
```
departments        - Divisi perusahaan
users             - Data karyawan & admin
attendances       - Absensi harian ✨ MAIN TABLE
leaves            - Pengajuan izin/cuti
leave_quotas      - Kuota cuti per tahun
shifts            - Jadwal kerja
user_shifts       - Penugasan shift
attendance_logs   - Log detail absensi
holidays          - Hari libur nasional
audit_logs        - Audit trail
sessions          - Laravel session
cache             - Laravel cache
jobs              - Queue jobs
password_reset_tokens - Password reset
```

### Key Features
✅ Multi-role (Admin, Karyawan, Manager)
✅ Attendance dengan foto & GPS
✅ Leave management dengan approval workflow
✅ Leave quota tracking
✅ Shift management
✅ Holiday management
✅ Audit logging
✅ Sample data sudah siap pakai

---

## 🔧 Next Steps untuk Backend Development

### 1. Create Models (Jika Belum Ada)
```bash
php artisan make:model Leave -m
php artisan make:model Department -m
php artisan make:model Shift -m
php artisan make:model Holiday -m
php artisan make:model LeaveQuota -m
php artisan make:model AuditLog -m
```

### 2. Update Existing Models dengan Relationships
Lihat file `DATABASE_SCHEMA.md` untuk relasi yang perlu ditambah

### 3. Implement Backend Controllers
- LeaveController (CRUD + approval)
- EmployeeController (CRUD)
- ReportController (PDF/Excel export)
- DashboardController (query actual data, bukan hardcoded)

### 4. Create API Endpoints (Optional)
Untuk mobile app atau frontend yang terpisah

### 5. Implement Middleware
- Role-based access control
- Leave approval workflow

---

## 📊 Database Diagram

```
┌──────────────────┐
│  departments     │
│  (5 divisi)      │
└────────┬─────────┘
         │
         ↓
┌──────────────────┐      ┌──────────────────┐
│     users        │──────│  shifts          │
│  (1 admin,       │      │  (3 shift)       │
│   6 karyawan)    │      └──────────────────┘
└────────┬─────────┘
         │
    ┌────┴────┬─────────┬─────────┐
    ↓         ↓         ↓         ↓
┌────────┐ ┌──────┐ ┌────────┐ ┌────────────┐
│attendan│ │leaves│ │user_   │ │leave_quota │
│ces     │ │(izin)│ │shifts  │ │(kuota)     │
│(absensi)│ └──────┘ └────────┘ └────────────┘
└────────┘

Other:
├── holidays (hari libur)
├── attendance_logs (detail log)
├── audit_logs (audit trail)
└── sessions, cache, jobs (Laravel internals)
```

---

## 🎯 Database Statistics

```
Departments: 5
├── Engineering
├── Marketing
├── HR
├── Finance
└── Operations

Shifts: 3
├── Shift Pagi (08:00-17:00)
├── Shift Siang (12:00-21:00)
└── Shift Malam (21:00-06:00)

Users: 7
├── 1 Admin
└── 6 Karyawan (aktif)

Sample Data:
├── Attendance records: 9 (5 hari terakhir)
├── Leave requests: 3 (pending, approved, rejected)
└── Holidays: 10 (Tahun 2026)
```

---

## ⚠️ IMPORTANT NOTES

1. **Database sudah termasuk data lengkap** - jangan lupa backup kalau butuh
2. **Sample data using password "password"** - change di production!
3. **File SQL bisa di-edit jika mau customize**
4. **Indexes sudah dioptimize** - jangan hapus
5. **Foreign keys dengan CASCADE** - delete parent = delete child

---

## 🐛 Troubleshooting

### Error: "SQLSTATE[HY000] [2002] Connection refused"
```
❌ Database tidak terhubung
✅ Solusi:
   - Check .env DB credentials
   - Pastikan MySQL running di Laragon
   - Try: php artisan config:cache
```

### Error: "Specified key was too long"
```
❌ Unique key terlalu panjang
✅ Solusi: 
   - Sudah di-handle di database.sql
   - Jika masih error, check DB charset
```

### Users tidak bisa login
```
❌ Password tidak benar
✅ Solusi:
   - Password default: "password" (lowercase)
   - Check database: SELECT email, password FROM users;
```

---

## 📚 Documentation Files

| File | Keterangan |
|------|-----------|
| **database.sql** | SQL schema + sample data |
| **DATABASE_SCHEMA.md** | Dokumentasi tabel lengkap |
| **PROJECT_ANALYSIS.md** | Analysis & implementation guide |
| **LARAVEL_MIGRATIONS.md** | Migration files format Laravel |
| **SETUP.md** | File ini (quick start) |

---

## 🎓 Learning Path

1. **Pahami Database Schema** → Read `DATABASE_SCHEMA.md`
2. **Analisis Project** → Read `PROJECT_ANALYSIS.md`
3. **Implementasikan Backend** → Follow checklist di PROJECT_ANALYSIS.md
4. **Test Fitur** → Use test users di section atas
5. **Deploy ke Production** → Update credentials & passwords

---

## 🔐 Production Checklist

Sebelum live:
- [ ] Change all default passwords
- [ ] Update DB credentials di .env
- [ ] Enable HTTPS
- [ ] Setup email notifications
- [ ] Configure rate limiting
- [ ] Enable two-factor authentication (optional)
- [ ] Setup backup strategy
- [ ] Test all workflows
- [ ] Security audit
- [ ] Performance testing

---

## 📞 Support Resources

- **Laravel Docs:** https://laravel.com/docs
- **MySQL Docs:** https://dev.mysql.com/doc
- **Blade Template:** https://laravel.com/docs/blade
- **Eloquent ORM:** https://laravel.com/docs/eloquent

---

## 🎉 Summary

✅ Database schema lengkap dengan 14 tabel
✅ Sample data siap pakai (7 users, 5 departments, 3 shifts, etc)
✅ Foreign keys & relationships ready
✅ Indexes untuk performance optimization
✅ Dokumentasi lengkap (4 files)
✅ SQL query examples included
✅ Ready untuk backend development

**Sekarang tinggal lanjutkan implementasi backend sesuai checklist di PROJECT_ANALYSIS.md! 🚀**

---

**Last Updated:** 2026-06-17
**Status:** ✅ Ready for Use
**Version:** 1.0

**Questions? Check the documentation files atau tanya tim development!**
