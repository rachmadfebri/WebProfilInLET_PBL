<?php
require_once __DIR__ . '/../model/galleryModel.php'; 

class galleryController {
  private $galleryModel;

  public function __construct(PDO $pdo) {
    // PERBAIKAN: Panggil session_start() hanya sekali di constructor
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    $this->galleryModel = new GalleryModel($pdo);
  }

  public function index() {
    if ($_SESSION['role'] !== 'admin') {
      header("Location: ?page=login");
      exit;
    }
    $galleries = $this->galleryModel->getAll(); 
    require __DIR__ . '/../views/admin/gallery.php';
  }

  public function create() {
    if ($_SESSION['role'] !== 'admin') {
      header("Location: ?page=login");
      exit;
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $imagePath = '';
      if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $newName = 'galeri_' . time() . '.' . $ext;
        
        // 1. Tentukan lokasi folder fisik (System Path)
        // Karena controller ada di app/controller, kita naik 2x (../../) lalu masuk public/uploads
        $uploadDir = __DIR__ . '/../../public/uploads/'; 
        
        // Pastikan folder ada
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        
        $uploadPath = $uploadDir . $newName;

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadPath)) {
          // 2. Tentukan alamat untuk Database (URL Path)
          // Cukup simpan 'uploads/namafile.jpg' karena index.php sudah ada di dalam folder public
          $imagePath = 'uploads/' . $newName; 
          
          // Simpan ke DB
          $this->galleryModel->create($imagePath);
        }
      }
      header("Location: index.php?page=gallery");
      exit;
    }
  }

  public function edit($id) {
    if ($_SESSION['role'] !== 'admin') {
      header("Location: ?page=login");
      exit;
    }

    // 1. CEK POST (User klik simpan perubahan)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Ambil data lama untuk jaga-jaga kalau gambar tidak diganti
      $oldData = $this->galleryModel->getById($id);
      $imagePath = $oldData['image']; 

      // Cek upload gambar baru
      if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $newName = 'galeri_' . time() . '.' . $ext;
        $uploadDir = __DIR__ . '/../../public/uploads/';
        
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        
        $uploadPath = $uploadDir . $newName;

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadPath)) {
          $imagePath = 'uploads/' . $newName;
        }
      }

      $this->galleryModel->update($id, $imagePath);
      // Redirect ke halaman bersih (hilangkan mode edit)
      header("Location: index.php?page=gallery");
      exit;
    }

    // 2. JIKA GET (Baru klik tombol edit)
    // Ambil data spesifik yang mau diedit
    $editData = $this->galleryModel->getById($id);

    // PENTING: Ambil juga SEMUA data galeri agar tabel di bawahnya tetap muncul
    $galleries = $this->galleryModel->getAll(); 

    // Panggil View yang SAMA dengan halaman utama
    require __DIR__ . '/../views/admin/gallery.php';
  }

  public function delete($id) {
    if ($_SESSION['role'] !== 'admin') {
      header("Location: ?page=login");
      exit;
    }
    
    $this->galleryModel->delete($id);
    
    // PERBAIKAN: Ganti '?page=tables' menjadi '?page=gallery'
    header("Location: index.php?page=gallery"); 
    exit;
  }
}