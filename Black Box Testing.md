# Black Box Testing – Gym App

## Deskripsi

Dokumen ini berisi implementasi **5 teknik Black Box Testing** pada aplikasi web **Gym App**.

Teknik yang digunakan:

1. Equivalence Partitioning
2. Boundary Value Analysis (BVA)
3. Decision Table Testing
4. State Transition Testing
5. Use Case Testing

---

# 1. Equivalence Partitioning

## Fitur: Login Member

**File:** `login.php`

### Pengertian

Equivalence Partitioning digunakan untuk membagi input menjadi kelompok valid dan tidak valid.

### Tabel Pengujian

| Kelas Data | Input                        | Expected Result |
| ---------- | ---------------------------- | --------------- |
| Valid      | Email benar & password benar | Login berhasil  |
| Invalid    | Email salah                  | Error login     |
| Invalid    | Password salah               | Error login     |
| Invalid    | Email kosong                 | Validasi gagal  |
| Invalid    | Password kosong              | Validasi gagal  |

### Kesimpulan

Login berhasil membedakan input valid dan tidak valid.

---

# 2. Boundary Value Analysis (BVA)

## Fitur: Registrasi Member

**File:** `daftar.php`

### Pengertian

Boundary Value Analysis digunakan untuk menguji batas minimum dan maksimum input.

### Pengujian Panjang Password

Misal password minimal **8 karakter**.

| Test Case | Input Password | Expected Result |
| --------- | -------------- | --------------- |
| BVA01     | 7 karakter     | Ditolak         |
| BVA02     | 8 karakter     | Diterima        |
| BVA03     | 9 karakter     | Diterima        |
| BVA04     | Kosong         | Ditolak         |

### Kesimpulan

Sistem berhasil memvalidasi batas input password.

---

# 3. Decision Table Testing

## Fitur: Login Admin

**File:** `admin/login.php`

### Pengertian

Decision Table digunakan untuk menguji kombinasi kondisi logika.

### Tabel Keputusan

| Kondisi | Username Valid | Password Valid | Result         |
| ------- | -------------- | -------------- | -------------- |
| Rule 1  | Ya             | Ya             | Login berhasil |
| Rule 2  | Ya             | Tidak          | Error          |
| Rule 3  | Tidak          | Ya             | Error          |
| Rule 4  | Tidak          | Tidak          | Error          |

### Kesimpulan

Semua kombinasi login admin berhasil diuji.

---

# 4. State Transition Testing

## Fitur: Status Membership

### Pengertian

State Transition Testing digunakan untuk menguji perubahan status sistem.

### Diagram State

```text id="zn0hty"
Inactive → Active → Expired
```

### Pengujian State

| Kondisi Awal | Aksi               | Kondisi Akhir |
| ------------ | ------------------ | ------------- |
| Inactive     | Aktivasi member    | Active        |
| Active       | Masa berlaku habis | Expired       |
| Expired      | Perpanjang member  | Active        |

### Kesimpulan

Perubahan status member berjalan sesuai aturan sistem.

---

# 5. Use Case Testing

## Fitur: Jadwal Gym

**File:** `jadwal.php`

### Pengertian

Use Case Testing digunakan untuk menguji alur penggunaan fitur oleh user.

### Use Case

#### Skenario Normal

1. User membuka halaman jadwal
2. User memilih hari latihan
3. Sistem menampilkan jadwal gym

#### Skenario Error

1. User tidak memilih hari
2. Sistem tidak menampilkan jadwal

### Hasil Pengujian

| Skenario            | Hasil                  |
| ------------------- | ---------------------- |
| Pilih hari tersedia | Jadwal tampil          |
| Hari tidak tersedia | Pesan tidak ada jadwal |
| Tidak memilih hari  | Tidak tampil           |

### Kesimpulan

Fitur jadwal gym berjalan sesuai alur penggunaan user.

---

# Kesimpulan Pengujian Black Box

Berdasarkan hasil pengujian menggunakan **5 teknik Black Box Testing**, seluruh fitur Gym App berjalan sesuai fungsi yang diharapkan.
