<?php
// app/controller/GalleryController.php

// Jalur relatif dari app/controller ke app/model
require_once __DIR__ . '/../model/galleryModel.php'; 

class galleryController {
    private $galleryModel;

    public function __construct(PDO $pdo) {
        $this->galleryModel = new GalleryModel($pdo);
    }

    /**
     * Menampilkan halaman galeri (untuk Admin atau Public).
     * Method ini akan dipanggil oleh router saat ?page=tables (sesuai diskusi Anda).
     */
    public function index() {
        session_start();
        
        // Asumsi: Hanya admin yang bisa mengakses route ini
        if ($_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        // Ambil semua data gambar
        $galleries = $this->galleryModel->getAll(); 
        
        // Muat view galeri Anda
        // Ganti 'gallery.php' dengan nama file view Anda yang sebenarnya, 
        // yang kita asumsikan ada di app/views/admin/
        require '../views/admin/gallery.php'; 
    }
    
    // Anda bisa menambahkan fungsi untuk upload/edit galeri di sini (jika diperlukan)
}