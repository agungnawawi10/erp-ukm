# 🚀 ERP UKM System

Sistem Enterprise Resource Planning (ERP) berbasis web modern yang dirancang khusus untuk skala UKM. Dibangun menggunakan teknologi terkini untuk mengotomatisasi pencatatan inventaris, siklus pembelian, transaksi penjualan, manajemen keuangan, hingga pelaporan analitik secara real-time.

---

## 🛠️ Tech Stack & Architecture

* **Framework Backend:** Laravel 13
* **Admin Panel & UI:** Laravel Filament  v5.6.7
* **Authorization:** Spatie Laravel Permission (Role & Permission Management)
* **Database Management:** MySQL 
* **Service Layer Pattern:** Terintegrasi dengan kustom *InventoryService* dan modul keuangan otomatis.

---

## 📦 Core Modules & Features

Sistem MVP ERP UKM ini mencakup modul-modul fungsional utama berikut:

1. **Authentication & User Management**
   * Secure Login & Logout system.
   * Role & Permission control (Super Admin, Manager, Cashier) menggunakan Spatie.
   * Manajemen Data User.

2. **Master Data**
   * CRUD Kategori Barang.
   * CRUD Supplier & Manajemen Relasi.
   * CRUD Produk lengkap dengan manajemen stok dan upload gambar.

3. **Inventory Management**
   * Pencatatan Stok Masuk & Stok Keluar.
   * Stock Movement Log (Riwayat pergerakan stok).
   * Validasi stok otomatis untuk mencegah *overselling*.

4. **Purchasing (Pembelian)**
   * Purchase Order (PO) Header & Detail.
   * Workflow Approval PO.
   * Proses Penerimaan Barang (*Receive Goods*) dengan *auto-update* stok inventaris secara real-time.

5. **Sales (Penjualan)**
   * Manajemen Pelanggan (Customer CRUD).
   * Transaksi Penjualan (*Sales Transaction*) dengan sistem *draft* dan *completed*.
   * Generate Nomor Invoice otomatis.
   * Pengurangan stok otomatis (*auto-deduct stock*) serta pencatatan pendapatan (*Income*) terintegrasi.
   * Cetak Invoice dalam format PDF.

6. **Finance & Accounting**
   * Modul Pencatatan Pemasukan (*Income*).
   * Modul Pencatatan Pengeluaran (*Expense*).
   * Laporan Arus Kas (*Cash Flow Report*) & Kalkulasi Laba (*Profit Calculation*).

7. **Reporting & Analytics**
   * Laporan Penjualan & Pembelian komprehensif.
   * Fitur Ekspor data ke format Excel dan PDF.
   * Dashboard interaktif dengan widget total sales, total produk, low-stock alert, dan grafik penjualan real-time.

---

## ⚙️ Installation & Setup

Ikuti langkah-langkah berikut untuk menjalankan proyek ini secara lokal:

1. **Clone Repository**
   ```bash
   git clone [https://github.com/username/erp-ukm.git](https://github.com/username/erp-ukm.git)
   cd erp-ukm