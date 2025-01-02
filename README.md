# **SiPatif - Sistem Admin Rumah Sakit**  
**Oleh:** Salsabilla Edlanda Putri  
**NIM:** 22.01.53.0047  

---

## **Deskripsi Proyek**
SiPatif adalah sistem berbasis web yang dirancang untuk mengelola administrasi klinik kesehatan. Sistem ini mendukung pengelolaan data pasien, dokter, jadwal, janji temu, rekam medis, resep obat, dan pembayaran. Sistem ini juga dilengkapi dengan layanan API RESTful untuk memudahkan integrasi dengan aplikasi lain atau mobile apps.

---

## **Fitur Utama**
### **1. Manajemen Dokter**
- Menambah, mengedit, dan menghapus data dokter.
- Menampilkan daftar dokter dengan spesialisasi dan status bertugas.

### **2. Manajemen Pasien**
- Registrasi pasien baru.
- Pencarian data pasien berdasarkan ID atau nama.

### **3. Jadwal Dokter**
- Mengelola jadwal kerja dokter berdasarkan hari dan jam.
- Menampilkan jadwal dokter yang tersedia untuk janji temu.

### **4. Janji Temu**
- Membuat janji temu pasien dengan dokter.
- Menjadwalkan layanan klinik berdasarkan jadwal dokter dan ruangan yang tersedia.

### **5. Rekam Medis**
- Mencatat riwayat keluhan, diagnosis, dan tindakan medis pasien.
- Menyimpan riwayat kesehatan pasien secara lengkap.

### **6. Resep Obat**
- Mengelola data resep obat yang diberikan dokter kepada pasien.
- Menyimpan data dosis, jumlah, dan instruksi penggunaan obat.

### **7. Pengelolaan Pembayaran**
- Mencatat transaksi pembayaran pasien untuk janji temu atau layanan.
- Menampilkan laporan pembayaran dengan status lunas atau belum lunas.

### **8. Penjadwalan Ruangan**
- Mengatur penggunaan ruangan untuk janji temu atau tindakan medis.

---

## **Struktur Database**
### **Tabel Utama:**
1. **Dokter**  
   Menyimpan data dokter, seperti ID, nama, spesialisasi, email, dan status bertugas.  

2. **Jadwal Dokter**  
   Mengelola jadwal kerja dokter berdasarkan hari dan jam.  

3. **Janji Temu**  
   Mencatat informasi janji temu pasien dengan dokter, termasuk tanggal, waktu, dan kategori layanan.  

4. **Pasien**  
   Menyimpan data pasien, seperti ID, nama, tanggal lahir, alamat, dan nomor rujukan.  

5. **Rekam Medis**  
   Mencatat data keluhan, diagnosis, dan tindakan medis pasien.  

6. **Resep**  
   Mengelola data resep obat yang diberikan dokter kepada pasien.  

7. **Obat**  
   Menyimpan data obat, seperti nama, jenis, stok, dan harga.  

8. **Pembayaran**  
   Mencatat transaksi pembayaran pasien untuk layanan klinik.  

9. **Ruangan**  
   Mengelola data ruangan yang digunakan untuk janji temu atau tindakan medis.  

---

## **Layanan API**
### **Dokter**
- `GET /api/dokter` - Menampilkan daftar dokter.  
- `POST /api/dokter` - Menambahkan data dokter baru.  
- `PUT /api/dokter/{id}` - Memperbarui data dokter.  
- `DELETE /api/dokter/{id}` - Menghapus data dokter.  

### **Pasien**
- `GET /api/pasien` - Menampilkan daftar pasien.  
- `POST /api/pasien` - Menambahkan pasien baru.  
- `PUT /api/pasien/{id}` - Memperbarui data pasien.  
- `DELETE /api/pasien/{id}` - Menghapus data pasien.  

### **Jadwal Dokter**
- `GET /api/jadwal_dokter` - Menampilkan jadwal dokter.  
- `POST /api/jadwal_dokter` - Menambahkan jadwal dokter baru.  

### **Janji Temu**
- `GET /api/janji_temu` - Menampilkan semua janji temu.  
- `POST /api/janji_temu` - Membuat janji temu baru.  

### **Rekam Medis**
- `GET /api/rekam_medis` - Menampilkan riwayat medis pasien.  
- `POST /api/rekam_medis` - Menambahkan rekam medis baru.  

### **Resep**
- `GET /api/resep` - Menampilkan resep pasien.  
- `POST /api/resep` - Menambahkan resep baru.  

### **Pembayaran**
- `GET /api/pembayaran` - Menampilkan daftar pembayaran.  
- `POST /api/pembayaran` - Menambahkan data pembayaran baru.  

### **Ruangan**
- `GET /api/ruangan` - Menampilkan daftar ruangan.  
- `POST /api/ruangan` - Menambahkan data ruangan baru.  

---

## **Teknologi yang Digunakan**
- **Backend:** PHP (Laravel/Lumen) untuk API RESTful.  
- **Frontend:** HTML, CSS, JavaScript (Vue.js atau React).  
- **Database:** MariaDB/MySQL.  
- **Version Control:** Git menggunakan GitHub untuk kolaborasi.  

---

## **Pengembang**
**Nama:** Salsabilla Edlanda Putri  
**NIM:** 22.01.53.0047  
**Program Studi:** Teknik Informatika  
**Dosen Pengampu:** Mardi Siswo Utomo  

---

😊
