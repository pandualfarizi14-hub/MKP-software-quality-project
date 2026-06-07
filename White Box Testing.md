# White Box Testing – Gym App

## Deskripsi

Dokumen ini berisi implementasi **White Box Testing** pada aplikasi web **Gym App** berdasarkan model pengujian white box:

* Desk Checking
* Code Walkthrough
* Formal Inspection
* Basic Path Testing
* Loop Testing

---

# 1. Desk Checking

## Fitur: Login Member

**File:** `login.php`

### Pengertian

Desk Checking merupakan teknik white box testing dengan cara memeriksa logika program secara manual tanpa menjalankan aplikasi.

### Potongan Kode

```php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

$email = $_POST['email'];
$password = $_POST['password'];

if ($row = mysqli_fetch_assoc($result)) {

if (password_verify(
$password,
$row['password'])) {

if ($row['status']
== 'active') {

header(
"Location:
dashboard.php");

} else {

$error =
"Akun belum aktif";
}

} else {

$error =
"Password salah";
}

} else {

$error =
"Email salah";
}
}
```

### Proses Desk Checking

| Langkah | Pemeriksaan                | Hasil |
| ------- | -------------------------- | ----- |
| 1       | Request POST diterima      | Valid |
| 2       | Email diambil dari form    | Valid |
| 3       | Password diambil dari form | Valid |
| 4       | Query mencari email        | Valid |
| 5       | Password diverifikasi      | Valid |
| 6       | Status akun dicek          | Valid |
| 7       | Redirect dashboard         | Valid |

### Kemungkinan Error

| Kondisi          | Output        |
| ---------------- | ------------- |
| Email salah      | Pesan error   |
| Password salah   | Pesan error   |
| Akun belum aktif | Akses ditolak |

### Kesimpulan

Alur login berjalan sesuai logika program.

---

# 2. Code Walkthrough

## Fitur: Registrasi Member

**File:** `daftar.php`

### Pengertian

Code Walkthrough merupakan teknik pengujian dengan menelusuri kode program langkah demi langkah.

### Potongan Kode

```php
if(isset($_POST['submit'])){

$password =
$_POST['password'];

$confirm_password =
$_POST['confirm_password'];

if($password ==
$confirm_password){

if($cek_email > 0){

$error =
"Email sudah ada";

}else{

mysqli_query(
$koneksi,
$query_insert);
}
}
}
```

### Langkah Walkthrough

1. User mengisi form registrasi
2. Sistem mengecek tombol submit
3. Sistem mengambil password dan confirm password
4. Sistem membandingkan password
5. Sistem mengecek email sudah ada atau belum
6. Sistem menyimpan akun baru

### Hasil Walkthrough

| Kondisi              | Hasil               |
| -------------------- | ------------------- |
| Password cocok       | Registrasi berhasil |
| Password tidak cocok | Error               |
| Email sudah ada      | Error               |

### Kesimpulan

Alur registrasi berhasil ditelusuri dan berjalan sesuai logika program.

---

# 3. Formal Inspection

## Fitur: Login Admin

**File:** `admin/login.php`

### Pengertian

Formal Inspection merupakan teknik pengujian dengan melakukan review kode secara sistematis untuk menemukan kelemahan.

### Potongan Kode

```php
$query =
mysqli_query(
$koneksi,
"SELECT * FROM admin
WHERE username='$username'");
```

### Hasil Pemeriksaan

| Bagian Kode    | Temuan           | Risiko          | Solusi             |
| -------------- | ---------------- | --------------- | ------------------ |
| Query Login    | Query langsung   | SQL Injection   | Prepared Statement |
| Password       | Tidak hashing    | Password bocor  | `password_hash()`  |
| Session        | Belum divalidasi | Bypass login    | Session validation |
| Error Handling | Error umum       | Sulit debugging | Tambah log         |

### Kesimpulan

Login admin masih memerlukan peningkatan keamanan.

---

# 4. Basic Path Testing

## Fitur: Kelola Member

**File:** `admin/kelola_member.php`

### Node Program

| Node | Keterangan          |
| ---- | ------------------- |
| 1    | Start               |
| 2    | Cek parameter hapus |
| 3    | Ambil ID member     |
| 4    | Query delete        |
| 5    | Query berhasil      |
| 6    | Redirect            |
| 7    | Error               |
| 8    | End                 |

### Control Flow Graph

```text
1 → 2

2(TRUE) → 3
2(FALSE) → 8

3 → 4

4 → 5

5(TRUE) → 6
5(FALSE) → 7

6 → 8
7 → 8
```

### Cyclomatic Complexity

```text
V(G) = E − N + 2P

E = 9
N = 8
P = 1

V(G)=9−8+2(1)=3
```

### Independent Path

#### Path 1 – Hapus Berhasil

```text
1 → 2 → 3 → 4 → 5 → 6 → 8
```

#### Path 2 – Hapus Gagal

```text
1 → 2 → 3 → 4 → 5 → 7 → 8
```

#### Path 3 – Parameter Tidak Ada

```text
1 → 2 → 8
```

### Kesimpulan

Fitur kelola member memiliki 3 jalur independen.

---

# 5. Loop Testing

## Fitur: Jadwal Gym

**File:** `jadwal.php`

### Pengertian

Loop Testing digunakan untuk menguji struktur perulangan pada program.

### Potongan Kode

```php
while(
$row =
mysqli_fetch_assoc(
$result))
{
echo
$row['jadwal'];
}
```

### Pengujian Loop

| No | Kondisi Loop | Hasil               |
| -- | ------------ | ------------------- |
| 1  | 0 data       | Tidak tampil jadwal |
| 2  | 1 data       | 1 jadwal tampil     |
| 3  | 5 data       | Semua tampil        |
| 4  | Banyak data  | Sistem normal       |

### Iterasi Loop

#### Iterasi 0

Loop tidak berjalan.

#### Iterasi 1

Loop berjalan satu kali.

#### Iterasi Banyak

Loop berjalan sesuai jumlah data.

### Kesimpulan

Perulangan berjalan sesuai jumlah data yang tersedia.
