# Gray Box Testing – Gym App

## Deskripsi

Dokumen ini berisi implementasi Gray Box Testing pada aplikasi Gym App. Pengujian dilakukan dengan mengetahui sebagian struktur internal sistem seperti database, session, query, dan alur program.

Teknik yang digunakan:

1. Matrix Testing
2. Regression Testing
3. Pattern Testing
4. Orthogonal Array Testing (OAT)

---

# 1. Matrix Testing

## Fitur: Login Member

### File: `login.php`

## Pengertian

Matrix Testing digunakan untuk mengidentifikasi hubungan antara input, proses, dan output dalam sistem.

## Komponen yang Diuji

| Input          | Proses Internal   | Output           |
| -------------- | ----------------- | ---------------- |
| Email valid    | Query database    | Data ditemukan   |
| Password valid | password_verify() | Login berhasil   |
| Status aktif   | Session dibuat    | Dashboard tampil |
| Email salah    | Query gagal       | Pesan error      |
| Password salah | Verifikasi gagal  | Pesan error      |

## Hasil Pengujian

| Skenario                 | Hasil          |
| ------------------------ | -------------- |
| Email dan password benar | Berhasil login |
| Password salah           | Error login    |
| Akun tidak aktif         | Login ditolak  |

## Kesimpulan

Hubungan antara input, proses internal, dan output berjalan sesuai rancangan sistem.

---

# 2. Regression Testing

## Fitur: Registrasi Member

### File: `daftar.php`

## Pengertian

Regression Testing dilakukan setelah perubahan sistem untuk memastikan fitur lama tetap berjalan normal.

## Skenario Pengujian

### Sebelum Perubahan

* Registrasi menggunakan email dan password.

### Setelah Perubahan

* Ditambahkan validasi minimal password 8 karakter.

## Test Case

| No | Pengujian                | Hasil Diharapkan |
| -- | ------------------------ | ---------------- |
| 1  | Registrasi valid         | Akun tersimpan   |
| 2  | Password < 8 karakter    | Ditolak          |
| 3  | Email sudah digunakan    | Ditolak          |
| 4  | Confirm password berbeda | Ditolak          |

## Hasil

Seluruh fungsi lama tetap berjalan setelah penambahan validasi.

## Kesimpulan

Tidak ditemukan bug baru setelah perubahan sistem.

---

# 3. Pattern Testing

## Fitur: Login Admin

### File: `admin/login.php`

## Pengertian

Pattern Testing digunakan untuk menemukan pola kesalahan yang sering muncul berdasarkan perilaku sistem.

## Pola yang Diuji

### Pattern 1

Login dengan username benar dan password salah berulang kali.

### Pattern 2

Login menggunakan username yang tidak terdaftar.

### Pattern 3

Login menggunakan field kosong.

## Hasil Pengujian

| Pola                           | Hasil          |
| ------------------------------ | -------------- |
| Username benar, password salah | Error login    |
| Username tidak ditemukan       | Error login    |
| Input kosong                   | Validasi gagal |

## Kesimpulan

Sistem mampu menangani pola kesalahan umum tanpa menyebabkan error sistem.

---

# 4. Orthogonal Array Testing (OAT)

## Fitur: Kelola Member

### File: `admin/kelola_member.php`

## Pengertian

Orthogonal Array Testing digunakan untuk mengurangi jumlah kombinasi pengujian namun tetap mencakup berbagai kemungkinan kondisi.

## Faktor Pengujian

### Faktor A – Role User

* A1 = Admin
* A2 = Member

### Faktor B – Status Data

* B1 = Ada
* B2 = Tidak Ada

### Faktor C – Aksi

* C1 = Tambah
* C2 = Edit
* C3 = Hapus

## Tabel Pengujian

| Test Case | Role   | Data      | Aksi   | Expected Result |
| --------- | ------ | --------- | ------ | --------------- |
| TC1       | Admin  | Ada       | Tambah | Berhasil        |
| TC2       | Admin  | Ada       | Edit   | Berhasil        |
| TC3       | Admin  | Ada       | Hapus  | Berhasil        |
| TC4       | Member | Ada       | Hapus  | Ditolak         |
| TC5       | Admin  | Tidak Ada | Edit   | Error           |
| TC6       | Admin  | Tidak Ada | Hapus  | Error           |

## Hasil

Seluruh kombinasi utama berhasil diuji tanpa harus mencoba semua kemungkinan kombinasi.

## Kesimpulan

Teknik OAT berhasil mempersingkat proses pengujian namun tetap mencakup kondisi penting pada fitur kelola member.

---

# Kesimpulan Gray Box Testing

Berdasarkan pengujian menggunakan:

1. Matrix Testing
2. Regression Testing
3. Pattern Testing
4. Orthogonal Array Testing

seluruh fitur utama Gym App berjalan sesuai kebutuhan sistem. Pengujian menunjukkan bahwa hubungan antara fungsi aplikasi dan struktur internal sistem telah bekerja dengan baik tanpa ditemukan kesalahan kritis.
