### 1. Simulasi Visual Wireframe dengan `style.css`

Jika rancangan dari `docs/wireframe.md` diterjemahkan ke elemen HTML dan digabungkan dengan `style.css` yang sudah ada, wujudnya akan seperti ini:

- **Kanvas Utama:** Seluruh halaman akan memiliki latar belakang abu-abu muda (`#f5f6f8`), dan teks utama berwarna abu-abu gelap (`#2b2b2b`) agar nyaman dibaca[cite: 4].
- **Bentuk Kotak (Card):** Halaman seperti Login, Dashboard, dan Form Transaksi akan menggunakan elemen `<section>`, sehingga otomatis dibungkus oleh kotak berlatar putih dengan sudut melengkung (`border-radius: 8px`) dan bayangan halus (`box-shadow`)[cite: 4].
- **Elemen Form:** Label isian form (seperti _Username_, _Anggota_, _Buku_) akan tercetak tebal (`font-weight: 600`). Kotak _input_ atau _dropdown_ akan memiliki garis tepi abu-abu tipis dengan batas lebar maksimal 400px yang responsif[cite: 4].
- **Tombol Aksi:** Tombol aksi utama (seperti "Masuk" atau "Simpan Peminjaman") akan mewarisi gaya `button[type="submit"]`, yaitu tampil sebagai kotak berwarna biru tema (`#1d5b8a`) solid tanpa garis bingkai[cite: 4].

### 2. Langkah-langkah Visual User Flow Peminjaman

Mengikuti _user flow_ Peminjaman Buku, berikut adalah bayangan perpindahan halamannya[cite: 2]:

1.  **`[Petugas Login]`**: Layar awal menampilkan _card_ putih di tengah halaman yang berisi form input _username_ dan _password_.
2.  **`[Dashboard]`**: Setelah login berhasil masuk, layar bertransisi ke antarmuka utama Petugas yang memuat deretan angka statistik dan tabel transaksi.
3.  **`[Pilih menu "Peminjaman Baru"]`**: Petugas mengarahkan kursor ke tombol "Aksi Cepat" yang ada di bawah kartu statistik, lalu mengkliknya.
4.  **`[Pilih Anggota]` -> `[Pilih Buku (stok > 0)]`**: Layar berganti menampilkan antarmuka "Form Peminjaman"[cite: 2]. Petugas memilih nama dari menu _dropdown_ anggota, lalu memilih judul dari _dropdown_ buku. Sesuai aturan sistem, buku yang stoknya habis otomatis tidak akan muncul di pilihan[cite: 1, 2].
5.  **`[Simpan]` -> `[Stok buku berkurang 1]`**: Petugas mengklik tombol simpan berwarna biru di bawah form[cite: 2]. Di balik layar, sistem otomatis mengeksekusi logika pengurangan stok tanpa memunculkan layar baru[cite: 1, 2].
6.  **`[Kembali ke Dashboard]`**: Halaman dimuat ulang dan mengembalikan pandangan Petugas ke layar utama Dashboard[cite: 2].

### 3. Komparasi Komponen: `index.html` vs Dashboard Petugas

Berikut adalah perbandingan antara elemen Beranda Tamu (`index.html`) yang sudah berjalan dengan rancangan baru Dashboard Petugas[cite: 2, 3]:

- **Bagian yang Sama Persis:**
  - Teks logo **"SIMPUS-Mini"** di pojok kiri atas _header_[cite: 2, 3].
  - Blok **Kartu Statistik** yang berisi 3 kotak data identik: "Total Buku", "Total Anggota", dan "Sedang Dipinjam"[cite: 2, 3]. Komponen ini akan tetap disusun menggunakan pola CSS Grid 3 kolom[cite: 4].
- **Bagian yang Baru:**
  - _Navbar_ bagian atas ditambahkan menu baru yaitu **"Peminjaman"** beserta indikator identitas sesi **"(Nama Petugas) Logout"** di sudut kanan[cite: 2].
  - Terdapat blok baru bernama **"Aksi Cepat"** yang berisi tombol pintasan untuk memicu transaksi cepat[cite: 2].
  - Terdapat blok **"Transaksi Terbaru"** di bagian bawah berupa tabel data yang menampilkan riwayat transaksi, dan otomatis menggunakan gaya baris selang-seling (_zebra stripes_) dari CSS bawaan tabel[cite: 2, 4].

# Jawaban Ide Latihan Tambahan (Jobsheet 4)

**Nama**: Rayana Jaka Surya  
**NIM**: 254107020026  
**Mata Kuliah**: Pemrograman Web

---

## 1. Wireframe Halaman "Registrasi Anggota Baru" (Aktor Tamu)

Karena halaman ini ditujukan untuk Tamu, menu di bagian _navbar_ tidak boleh menampilkan fitur CRUD atau Peminjaman seperti di Dashboard Petugas. Tampilannya hanya menu publik seperti Beranda dan Daftar Buku.

```text
+-------------------------------------------------------------+
| SIMPUS-Mini                            Beranda | Daftar Buku|
|-------------------------------------------------------------|
|                                                             |
|  Registrasi Anggota Baru                                    |
|                                                             |
|  Nama Lengkap : [_________________________________]         |
|  Alamat       : [_________________________________]         |
|  No. HP       : [_________________________________]         |
|                                                             |
|                 [    Daftar Sekarang    ]                   |
|                                                             |
|  Sudah punya akun? Login Petugas di sini                    |
+-------------------------------------------------------------+
```

## 2. User Flow Baru: Mencari Anggota yang Menunggak

Mengacu pada halaman Daftar Anggota yang sudah dibangun pada `anggota/list.html` di Jobsheet 1, berikut adalah alur di mana Petugas menggunakan halaman tersebut untuk memfilter data:

`[Petugas Login]` -> `[Dashboard]` -> `[Pilih Menu "Daftar Anggota"]` -> `[Pilih Filter/Tab "Lewat Jatuh Tempo"]` -> `[Tabel menampilkan daftar anggota menunggak]` -> `[Klik tombol "Detail" pada baris anggota]` -> `[Tampil Riwayat Peminjaman & Total Denda]`

## 3. Identifikasi Edge Case Tambahan

Berdasarkan sistem yang sudah berjalan di Jobsheet 1 hingga 3, berikut adalah _edge case_ (kasus khusus) yang sangat relevan:

- **Kasus Penghapusan Data Master:** Apa yang terjadi jika Petugas menekan tombol "Hapus" pada buku atau anggota yang **masih memiliki transaksi peminjaman aktif**?
  - _Solusi Rancangan:_ Sistem tidak boleh langsung menghapusnya. Sistem harus memunculkan pesan _error_ (misal: "Gagal menghapus: Anggota ini masih meminjam buku") untuk menjaga integritas data (mencegah _foreign key error_ di database nantinya).
- **Kasus Akses URL Langsung (Otorisasi):** Apa yang terjadi jika aktor Tamu iseng langsung mengetikkan URL `buku/tambah.html` di browser mereka?
  - _Solusi Rancangan:_ Karena Tamu seharusnya tidak bisa melakukan fitur CRUD, sistem otorisasi harus mengecek status sesi. Jika URL tersebut diakses tanpa login, sistem otomatis me-_redirect_ Tamu kembali ke halaman Login.

## 4. Implementasi Wireframe Login ke HTML Statis

Agar halaman Login otomatis memiliki desain yang rapi dan konsisten dengan halaman lain (tombol biru, form lebar 100% max 400px), kode HTML-nya **wajib** mengikuti struktur form persis seperti di `buku/tambah.html` dari Jobsheet 1.

```html
<!-- Diletakkan di dalam tag <main> dan <section> -->
<section>
  <h2>Login Petugas</h2>
  <form action="#" method="POST">
    <!-- Mengikuti pola form p > label + br + input dari Jobsheet 1 -->
    <p>
      <label for="username">Username</label><br />
      <input type="text" id="username" name="username" required />
    </p>

    <p>
      <label for="password">Password</label><br />
      <!-- Menggunakan type="password" agar teks disembunyikan -->
      <input type="password" id="password" name="password" required />
    </p>

    <p>
      <!-- Karena menggunakan type="submit", otomatis terkena styling form button[type="submit"] dari Jobsheet 2 -->
      <button type="submit">Masuk</button>
    </p>
  </form>
  <br />
  <p>Belum punya akun? <a href="#">Daftar di sini</a></p>
</section>
```
