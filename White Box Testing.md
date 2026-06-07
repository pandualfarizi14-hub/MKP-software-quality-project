# White Box Testing – Gym App

## Deskripsi

Dokumen ini berisi implementasi **White Box Testing** pada aplikasi web **Gym App** menggunakan **5 teknik pengujian** dengan fitur yang berbeda-beda.

---

# 1. Statement Coverage

### Fitur: Login Member

**File:** `login.php`

## Pengertian

Statement Coverage bertujuan memastikan seluruh statement atau baris kode dieksekusi minimal satu kali.

## Potongan Kode

```php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

$email = $_POST['email'];
$password = $_POST['password'];

$result = mysqli_query($koneksi,$query);

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

## Skenario Pengujian

| No | Input          | Expected Result |
| -- | -------------- | --------------- |
| 1  | Login benar    | Berhasil masuk  |
| 2  | Password salah | Error           |
| 3  | Email salah    | Error           |
| 4  | Akun nonaktif  | Error           |

## Kesimpulan

Semua statement berhasil dieksekusi minimal satu kali.

---

# 2. Branch Coverage

### Fitur: Registrasi Member

**File:** `daftar.php`

## Pengertian

Branch Coverage digunakan untuk menguji semua percabangan TRUE dan FALSE.

## Percabangan yang Diuji

### Branch 1

```php
if(isset($_POST['submit']))
```

TRUE → proses daftar
FALSE → tampil form

### Branch 2

```php
if($password == $confirm_password)
```

TRUE → lanjut simpan akun
FALSE → tampil error

### Branch 3

```php
if($cek_email > 0)
```

TRUE → email sudah terdaftar
FALSE → akun baru disimpan

## Hasil Pengujian

Semua branch TRUE dan FALSE berhasil diuji.

## Kesimpulan

Branch Coverage berhasil diterapkan pada fitur registrasi member.

---

# 3. Basis Path Testing

### Fitur: Login Admin

**File:** `admin/login.php`

## Node Program

1 = Start
2 = Input username & password
3 = Query admin database
4 = Username ditemukan?
5 = Password benar?
6 = Login berhasil
7 = Login gagal
8 = End

## Cyclomatic Complexity

Rumus:

V(G) = E − N + 2P

E = 9
N = 8
P = 1

Hasil:

```text
V(G)=9−8+2(1)=3
```

Terdapat **3 independent path**.

### Independent Path

#### Path 1

1 → 2 → 3 → 4 → 5 → 6 → 8

#### Path 2

1 → 2 → 3 → 4 → 7 → 8

#### Path 3

1 → 2 → 3 → 7 → 8

## Kesimpulan

Fitur login admin memiliki 3 jalur independen.

---

# 4. Control Flow Graph (CFG) & Graph Matrix

### Fitur: Kelola Member Admin

**File:** `admin/kelola_member.php`

## Potongan Kode

```php
if(isset($_GET['hapus'])){

$id = $_GET['hapus'];

$query =
mysqli_query(
$koneksi,
"DELETE FROM
members
WHERE id='$id'");

if($query){

header(
"Location:
kelola_member.php");

}else{

$error =
"Gagal menghapus";
}
}
```

## Node Program

| Node | Keterangan          |
| ---- | ------------------- |
| 1    | Start               |
| 2    | Cek parameter hapus |
| 3    | Ambil ID            |
| 4    | Query delete        |
| 5    | Query berhasil      |
| 6    | Redirect            |
| 7    | Error               |
| 8    | End                 |

## Graph Matrix

| Node | 1 | 2 | 3 | 4 | 5 | 6 | 7 | 8 |
| ---- | - | - | - | - | - | - | - | - |
| 1    | - | 1 | 0 | 0 | 0 | 0 | 0 | 0 |
| 2    | 0 | - | 1 | 0 | 0 | 0 | 0 | 1 |
| 3    | 0 | 0 | - | 1 | 0 | 0 | 0 | 0 |
| 4    | 0 | 0 | 0 | - | 1 | 0 | 0 | 0 |
| 5    | 0 | 0 | 0 | 0 | - | 1 | 1 | 0 |
| 6    | 0 | 0 | 0 | 0 | 0 | - | 0 | 1 |
| 7    | 0 | 0 | 0 | 0 | 0 | 0 | - | 1 |
| 8    | 0 | 0 | 0 | 0 | 0 | 0 | 0 | - |

## Kesimpulan

CFG dan Graph Matrix berhasil menunjukkan hubungan antar node pada fitur kelola member.

---

## 5. Independent Path – Cyclomatic Complexity

### Fitur: Jadwal Gym (`jadwal.php`)

## Potongan Kode Program

```php id="uk0gnx"
if(isset($_POST['hari'])){

$hari = $_POST['hari'];

if($hari == "senin"){

echo "Latihan Cardio";

}elseif($hari == "selasa"){

echo "Latihan Upper Body";

}else{

echo "Tidak ada jadwal";
}
}
```

## Node Program

1 = Start
2 = Input Hari
3 = Cek Input Hari (`isset`)
4 = Hari = Senin?
5 = Tampilkan "Latihan Cardio"
6 = Hari = Selasa?
7 = Tampilkan "Latihan Upper Body"
8 = Tampilkan "Tidak ada jadwal"
9 = End

---

### Path 1 – Jadwal Hari Senin

#### Jalur Node

1 → 2 → 3 → 4 → 5 → 9

#### Kondisi Percabangan

* Node 3 = TRUE
  (input hari tersedia)

* Node 4 = TRUE
  (`hari = senin`)

#### Skenario Pengujian

| Input | Nilai |
| ----- | ----- |
| Hari  | senin |

#### Expected Result

Sistem menampilkan:

```text id="ldo3fr"
Latihan Cardio
```

#### Baris Kode yang Dilewati

Baris 1–7

---

### Path 2 – Jadwal Hari Selasa

#### Jalur Node

1 → 2 → 3 → 4 → 6 → 7 → 9

#### Kondisi Percabangan

* Node 3 = TRUE
  (input hari tersedia)

* Node 4 = FALSE
  (`hari ≠ senin`)

* Node 6 = TRUE
  (`hari = selasa`)

#### Skenario Pengujian

| Input | Nilai  |
| ----- | ------ |
| Hari  | selasa |

#### Expected Result

Sistem menampilkan:

```text id="jrr3uo"
Latihan Upper Body
```

#### Baris Kode yang Dilewati

Baris 1–11

---

### Path 3 – Hari Tidak Tersedia

#### Jalur Node

1 → 2 → 3 → 4 → 6 → 8 → 9

#### Kondisi Percabangan

* Node 3 = TRUE
  (input hari tersedia)

* Node 4 = FALSE
  (`hari ≠ senin`)

* Node 6 = FALSE
  (`hari ≠ selasa`)

#### Skenario Pengujian

| Input | Nilai  |
| ----- | ------ |
| Hari  | minggu |

#### Expected Result

Sistem menampilkan:

```text id="qjglwq"
Tidak ada jadwal
```

#### Baris Kode yang Dilewati

Baris 1–15

---

### Path 4 – Input Tidak Dimasukkan

#### Jalur Node

1 → 2 → 3 → 9

#### Kondisi Percabangan

* Node 3 = FALSE
  (`hari` tidak diinput)

#### Skenario Pengujian

| Input | Nilai  |
| ----- | ------ |
| Hari  | kosong |

#### Expected Result

Sistem tidak menampilkan jadwal.

#### Baris Kode yang Dilewati

Baris 1–2
