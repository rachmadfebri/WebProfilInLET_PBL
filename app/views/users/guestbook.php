<?php
// Public Guestbook page - untuk pengunjung mengisi buku tamu
require_once __DIR__ . '/../../model/guestBookModel.php';
require_once __DIR__ . '/../../../config/database.php';

$database = new Database();
$pdo = $database->connect();

$message = '';
$messageType = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $institution = trim($_POST['institution'] ?? '');
    $message_text = trim($_POST['message'] ?? '');
    
    if (empty($name) || empty($email) || empty($message_text)) {
        $message = 'Mohon lengkapi semua field yang wajib diisi.';
        $messageType = 'error';
    } else {
        try {
            $guestBookModel = new GuestBookModel($pdo);
            $success = $guestBookModel->create([
                'name' => $name,
                'email' => $email,
                'institution' => $institution,
                'message' => $message_text
            ]);
            
            if ($success) {
                $message = 'Terima kasih! Pesan Anda telah berhasil dikirim.';
                $messageType = 'success';
                // Clear form data
                $_POST = [];
            } else {
                $message = 'Terjadi kesalahan saat mengirim pesan. Silakan coba lagi.';
                $messageType = 'error';
            }
        } catch (Exception $e) {
            error_log("Guestbook Error: " . $e->getMessage());
            $message = 'Terjadi kesalahan sistem. Silakan coba lagi nanti.';
            $messageType = 'error';
        }
    }
}

// Get recent guestbook entries to display
try {
    $guestBookModel = new GuestBookModel($pdo);
    $recentEntries = $guestBookModel->getRecent(6); // Get 6 recent entries
} catch (Exception $e) {
    error_log("Guestbook Display Error: " . $e->getMessage());
    $recentEntries = [];
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guestbook • Learning Engineering Technology</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .guestbook-page {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .guestbook-header {
            text-align: center;
            margin-bottom: 60px;
        }
        
        .guestbook-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #2d5bd4 0%, #d53f8c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .guestbook-subtitle {
            font-size: 1.2rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }
        
        .guestbook-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: start;
        }
        
        .guestbook-form {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 2px solid #f0f0f0;
        }
        
        .guestbook-form h3 {
            font-size: 1.5rem;
            margin-bottom: 30px;
            color: #333;
            text-align: center;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }
        
        .required {
            color: #e74c3c;
        }
        
        .form-control {
            width: 100%;
            padding: 15px;
            border: 2px solid #e1e8ed;
            border-radius: 10px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }
        
        .submit-btn {
            width: 100%;
            background: linear-gradient(135deg, #2d5bd4 0%, #d53f8c 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
        }
        
        .submit-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        
        .message {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        
        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .recent-entries {
            background: #f8f9fa;
            padding: 40px;
            border-radius: 20px;
        }
        
        .recent-entries h3 {
            font-size: 1.5rem;
            margin-bottom: 30px;
            color: #333;
            text-align: center;
        }
        
        .entry {
            background: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            border-left: 4px solid #667eea;
        }
        
        .entry:last-child {
            margin-bottom: 0;
        }
        
        .entry-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .entry-name {
            font-weight: 600;
            color: #333;
        }
        
        .entry-date {
            font-size: 0.85rem;
            color: #666;
        }
        
        .entry-institution {
            font-size: 0.9rem;
            color: #667eea;
            margin-bottom: 10px;
        }
        
        .entry-message {
            color: #555;
            line-height: 1.6;
        }
        
        @media (max-width: 768px) {
            .guestbook-content {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            
            .guestbook-form,
            .recent-entries {
                padding: 25px;
            }
            
            .guestbook-title {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body class="page page-guestbook">

    <?php include 'header.php'; ?>

    <main class="page-wrapper">
        <div class="guestbook-page">
            <div class="guestbook-header">
                <h1 class="guestbook-title">Guestbook</h1>
                <p class="guestbook-subtitle">
                    Tinggalkan pesan, kesan, atau saran Anda kepada Learning Engineering Technology Research Group. 
                    Masukan Anda sangat berharga untuk pengembangan kami ke depan.
                </p>
            </div>
            
            <div class="guestbook-content">
                <div class="guestbook-form">
                    <h3><i class="fas fa-edit"></i> Tulis Pesan Anda</h3>
                    
                    <?php if ($message): ?>
                        <div class="message <?= $messageType ?>">
                            <?= htmlspecialchars($message) ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="name">Nama <span class="required">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" 
                                   value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email <span class="required">*</span></label>
                            <input type="email" id="email" name="email" class="form-control"
                                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="institution">Institusi/Organisasi</label>
                            <input type="text" id="institution" name="institution" class="form-control"
                                   value="<?= htmlspecialchars($_POST['institution'] ?? '') ?>" 
                                   placeholder="Nama universitas, perusahaan, atau organisasi">
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Pesan <span class="required">*</span></label>
                            <textarea id="message" name="message" class="form-control" required 
                                      placeholder="Tulis pesan, kesan, saran, atau pertanyaan Anda..."><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                        </div>
                        
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-paper-plane"></i> Kirim Pesan
                        </button>
                    </form>
                </div>
                
                <div class="recent-entries">
                    <h3><i class="fas fa-comments"></i> Pesan Terbaru</h3>
                    
                    <?php if (!empty($recentEntries)): ?>
                        <?php foreach ($recentEntries as $entry): ?>
                            <div class="entry">
                                <div class="entry-header">
                                    <span class="entry-name"><?= htmlspecialchars($entry['name']) ?></span>
                                    <span class="entry-date"><?= !empty($entry['created_at']) ? date('d M Y', strtotime($entry['created_at'])) : 'Unknown Date' ?></span>
                                </div>
                                <?php if (!empty($entry['institution'])): ?>
                                    <div class="entry-institution"><?= htmlspecialchars($entry['institution']) ?></div>
                                <?php endif; ?>
                                <div class="entry-message"><?= htmlspecialchars($entry['message']) ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="text-align: center; color: #666; padding: 40px 20px;">
                            <i class="fas fa-comment-slash" style="font-size: 3rem; margin-bottom: 20px; opacity: 0.5;"></i>
                            <p>Belum ada pesan. Jadilah yang pertama!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

</body>

</html>