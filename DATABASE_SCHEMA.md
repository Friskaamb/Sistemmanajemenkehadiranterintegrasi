# DATABASE SCHEMA - SISTEM MANAJEMEN KEHADIRAN TERINTEGRASI

## 📋 Daftar Tabel

### 1. **departments** - Divisi/Departemen
Menyimpan data departemen perusahaan
```
- id (Primary Key)
- nama (VARCHAR 100) - Nama departemen
- deskripsi (TEXT) - Deskripsi departemen
- manager_id (Foreign Key) - ID manager departemen
```

### 2. **users** - Pengguna/Karyawan
Tabel utama untuk autentikasi dan data karyawan
```
- id (Primary Key)
- name - Nama karyawan
- email (UNIQUE) - Email
- password - Password terenkripsi
- nik (UNIQUE) - Nomor Identitas Karyawan
- role - ENUM: admin, karyawan, manager
- department_id (Foreign Key) - Departemen yang ditugaskan
- phone - Nomor telepon
- address - Alamat
- photo - Path foto profil
- hire_date - Tanggal bergabung
- status - ENUM: aktif, nonaktif, cuti, resign
```

### 3. **attendances** - Absensi/Kehadiran
Catatan absensi harian karyawan
```
- id (Primary Key)
- user_id (Foreign Key) - ID karyawan
- tanggal - Tanggal absensi
- jam_masuk - Jam masuk kerja
- jam_pulang - Jam pulang kerja
- foto_masuk - Path foto absen masuk
- foto_pulang - Path foto absen pulang
- status - ENUM: Hadir, Terlambat, Izin, Sakit, Cuti, Libur, Tidak Hadir
- gps_status - Status verifikasi GPS (Verified, Unverified, Out of Range)
- total_jam - Total jam kerja (calculated)
- catatan - Catatan tambahan
- UNIQUE CONSTRAINT: user_id + tanggal (1 record per karyawan per hari)
```

### 4. **leaves** - Izin/Cuti
Pengajuan izin dan cuti karyawan
```
- id (Primary Key)
- user_id (Foreign Key) - ID karyawan yang mengajukan
- jenis_izin - ENUM: Cuti Tahunan, Sakit, Izin Pribadi, Izin Pernikahan, Kematian, Cuti Bersama
- tgl_mulai - Tanggal mulai izin
- tgl_selesai - Tanggal selesai izin
- alasan - Alasan pengajuan
- lampiran - Path file lampiran (surat dokter, etc)
- status - ENUM: Pending, Disetujui, Ditolak, Dibatalkan
- approved_by (Foreign Key) - ID user yang approve
- approval_date - Tanggal approval
- catatan_persetujuan - Catatan saat approve/reject
- jumlah_hari - Total hari izin (calculated)
```

### 5. **leave_quotas** - Kuota Cuti Tahunan
Menyimpan kuota cuti per tahun per karyawan
```
- id (Primary Key)
- user_id (Foreign Key) - ID karyawan
- tahun - Tahun berlaku
- kuota_cuti_tahunan - Total hari cuti (default: 12)
- kuota_sakit - Total hari sakit (default: 12)
- kuota_izin_pribadi - Total hari izin pribadi (default: 3)
- sisa_cuti_tahunan - Sisa cuti (updated saat leave approved)
- sisa_sakit - Sisa sakit
- sisa_izin_pribadi - Sisa izin pribadi
- UNIQUE CONSTRAINT: user_id + tahun
```

### 6. **shifts** - Jadwal Kerja/Shift
Master data shift kerja
```
- id (Primary Key)
- nama - Nama shift (Shift Pagi, Shift Siang, Shift Malam)
- jam_masuk - Jam mulai shift
- jam_pulang - Jam akhir shift
- toleransi_terlambat - Menit toleransi keterlambatan (default: 15)
- aktif - Status shift
```

### 7. **user_shifts** - Penugasan Shift
Penugasan shift ke karyawan
```
- id (Primary Key)
- user_id (Foreign Key) - ID karyawan
- shift_id (Foreign Key) - ID shift
- tgl_berlaku - Tanggal mulai berlaku
- tgl_berakhir - Tanggal akhir (NULL = sekarang aktif)
```

### 8. **attendance_logs** - Log Detail Absensi
Log detail setiap absensi (opsional untuk tracking lengkap)
```
- id (Primary Key)
- user_id (Foreign Key) - ID karyawan
- tanggal - Tanggal absensi
- jam - Jam absensi
- tipe - ENUM: masuk, pulang
- latitude - Koordinat GPS
- longitude - Koordinat GPS
- accuracy - Akurasi GPS (meter)
- foto - Path foto
- device_info - Info device
- ip_address - IP address
```

### 9. **holidays** - Hari Libur
Master data hari libur nasional dan perusahaan
```
- id (Primary Key)
- nama - Nama hari libur
- tanggal (UNIQUE) - Tanggal libur
- tipe - ENUM: Nasional, Perusahaan, Regional
- deskripsi - Keterangan hari libur
```

### 10. **audit_logs** - Audit Trail
Log perubahan data untuk compliance
```
- id (Primary Key)
- user_id (Foreign Key) - Siapa yang melakukan perubahan
- aksi - Tipe aksi (INSERT, UPDATE, DELETE)
- tabel - Nama tabel yang diubah
- data_lama - Data sebelum perubahan (JSON)
- data_baru - Data setelah perubahan (JSON)
- ip_address - IP address
```

### 11. **password_reset_tokens** - Token Reset Password
```
- email (Primary Key)
- token - Token untuk reset password
- created_at - Waktu pembuatan token
```

### 12. **sessions** - Session Laravel
```
- id (Primary Key)
- user_id (Foreign Key) - ID user yang login
- ip_address - IP address
- user_agent - Browser/device info
- payload - Session data
- last_activity - Waktu aktivitas terakhir
```

### 13. **cache** - Cache Data
Untuk caching di database

### 14. **jobs** - Queue Jobs
Untuk background jobs processing

---

## 📊 Relasi Tabel

```
departments
    ↓
users (many) ← department_id
    ↓ (one-to-many)
    ├─ attendances (many)
    ├─ leaves (many)
    ├─ leave_quotas (many)
    └─ user_shifts (many)
    
shifts
    ↓
user_shifts (many) ← shift_id

leaves
    ↓
    └─ approved_by → users (admin/manager)

holidays (independent)
attendance_logs (detail dari attendances)
audit_logs (tracking)
```

---

## 🔑 Key Features

### ✅ Attendance Management
- Absen masuk/pulang dengan foto
- Verifikasi GPS
- Tracking terlambat otomatis
- Riwayat absensi lengkap

### ✅ Leave Management
- Pengajuan izin/cuti dengan workflow approval
- Tracking kuota cuti per tahun
- Support berbagai tipe izin
- Lampiran dokumen (surat sakit, etc)

### ✅ Employee Management
- Data karyawan lengkap
- Penugasan departemen & shift
- Status karyawan tracking
- Photo profile

### ✅ Reporting
- Monthly attendance summary
- Employee leave status overview
- Holiday management
- Audit trail untuk compliance

---

## 🚀 Setup Instructions

### 1. Import Database (MySQL)
```bash
# Method 1: Command line
mysql -u root -p sistem_kehadiran_db < database.sql

# Method 2: phpMyAdmin
- Buka phpMyAdmin
- Create new database: sistem_kehadiran_db
- Import file database.sql
```

### 2. Update Laravel .env
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_kehadiran_db
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Run Laravel Migrations
```bash
php artisan migrate
```

Atau buat migration files baru:
```bash
# Jika ingin update struktur existing
php artisan make:migration add_fields_to_users_table
php artisan make:migration add_fields_to_attendances_table
```

### 4. Seed Sample Data (Optional)
Buat seeder file di `database/seeders/` untuk memasukkan sample data

---

## 📋 Sample Test Data

### Admin Account
- Email: `admin@ptdfl.com`
- Password: `password`
- Role: `admin`

### Sample Employees
- budi@ptdfl.com (Engineering)
- ani@ptdfl.com (Marketing)
- rudi@ptdfl.com (HR)
- sarah@ptdfl.com (Engineering)
- david@ptdfl.com (Marketing)
- michael@ptdfl.com (HR)

**Password untuk semua:** `password`

---

## 🔒 Security Notes

1. **Password Hashing**: Semua password di-hash dengan bcrypt (Laravel default)
2. **Foreign Keys**: Terapkan relasi dengan ON DELETE CASCADE/SET NULL sesuai kebutuhan
3. **Indexes**: Sudah ada untuk query performance
4. **Audit Logs**: Untuk tracking semua perubahan data

---

## 📈 Performance Optimization

### Indexes yang Sudah Ada:
- `idx_attendances_user_tanggal` - Query attendance by user & date
- `idx_attendances_status_tanggal` - Query attendance by status & date
- `idx_leaves_user_status` - Query leaves by user & status
- `idx_users_department_status` - Query users by department

### Rekomendasi Query Optimization:
```sql
-- Attendance bulan ini
SELECT * FROM attendances 
WHERE user_id = ? AND YEAR(tanggal) = ? AND MONTH(tanggal) = ?

-- Employee leave status
SELECT u.*, lq.sisa_cuti_tahunan FROM users u
LEFT JOIN leave_quotas lq ON u.id = lq.user_id
WHERE lq.tahun = YEAR(NOW())

-- Pending leave requests
SELECT l.*, u.name, d.nama as department FROM leaves l
JOIN users u ON l.user_id = u.id
LEFT JOIN departments d ON u.department_id = d.id
WHERE l.status = 'Pending'
```

---

## 📌 Catatan Implementasi

### Fitur yang Perlu di-Backend:
1. ✅ User Management (CRUD Karyawan)
2. ✅ Attendance Recording
3. ✅ Leave Approval Workflow
4. ✅ Attendance Reports (PDF/Excel)
5. ✅ Dashboard Statistics
6. ✅ Authentication & Authorization
7. ✅ Leave Quota Management
8. ✅ GPS Verification (Opsional)

### Model Laravel yang Perlu Dibuat:
```
- User (sudah ada)
- Attendance (sudah ada partial)
- Leave (perlu dibuat)
- Department (perlu dibuat)
- Shift (perlu dibuat)
- Holiday (perlu dibuat)
- LeaveQuota (perlu dibuat)
- AuditLog (perlu dibuat)
```

### API Endpoints yang Perlu Diimplementasi:
```
POST   /api/login
POST   /api/logout
GET    /api/user/profile
PUT    /api/user/profile

GET    /api/attendance/today
POST   /api/attendance/checkin
POST   /api/attendance/checkout
GET    /api/attendance/history

POST   /api/leaves
GET    /api/leaves/status
GET    /api/leaves/pending (admin)
PUT    /api/leaves/:id/approve (admin)
PUT    /api/leaves/:id/reject (admin)

GET    /api/employees (admin)
POST   /api/employees (admin)
PUT    /api/employees/:id (admin)
DELETE /api/employees/:id (admin)

GET    /api/reports/attendance (admin)
GET    /api/reports/leave (admin)
GET    /api/dashboard (dashboard data)
```

---

## 🎯 Tahapan Development

1. **Phase 1: Database & Models** ✅
   - Setup database schema
   - Create Laravel models & relationships

2. **Phase 2: Authentication**
   - Login/Register
   - Password reset
   - Role-based access control

3. **Phase 3: Attendance Module**
   - Checkin/Checkout functionality
   - Photo capture
   - GPS verification

4. **Phase 4: Leave Management**
   - Leave request form
   - Approval workflow
   - Quota management

5. **Phase 5: Admin Dashboard**
   - Reports & analytics
   - Employee management
   - System configuration

6. **Phase 6: Optimization & Testing**
   - Performance tuning
   - Security hardening
   - Unit & integration tests

---

## 📞 Support

Untuk pertanyaan atau isu terkait database schema, silakan hubungi tim development.

**Last Updated:** 2026-06-17
