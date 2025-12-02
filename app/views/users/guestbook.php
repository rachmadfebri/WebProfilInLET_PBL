<?php
// Handle form submission
$successMessage = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        require_once __DIR__ . '/../../model/guestBookModel.php';
        $guestbookModel = new GuestbookModel($pdo);
        
        // Prepare data
        $data = [
            'name' => $_POST['name'] ?? '',
            'institution' => $_POST['institution'] ?? '',
            'email' => $_POST['email'] ?? '',
            'phone_number' => $_POST['phone'] ?? '',
            'message' => $_POST['message'] ?? ''
        ];
        
        // Validate required fields
        if (empty($data['name']) || empty($data['institution']) || empty($data['email']) || 
            empty($data['phone_number']) || empty($data['message'])) {
            $errorMessage = 'Semua field harus diisi!';
        } else {
            // Insert to database
            if ($guestbookModel->create($data)) {
                $successMessage = 'Terima kasih! Pesan Anda sudah dikirim.';
                // Clear form
                $_POST = [];
            } else {
                $errorMessage = 'Gagal mengirim pesan. Silakan coba lagi.';
            }
        }
    } catch (Exception $e) {
        error_log("Guestbook Error: " . $e->getMessage());
        $errorMessage = 'Terjadi kesalahan: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran</title>
    
    <link rel="stylesheet" href="assets/css/style.css"> 
    <link rel="stylesheet" href="assets/css/form-page.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .alert {
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            font-weight: 500;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body class="page-form">

    <?php include 'header.php'; ?> 
    
    <section class="form-section">
        
        <h1 class="form-title gradient-text">Guestbook</h1>
        
        <div class="form-container">
            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($successMessage); ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($errorMessage); ?>
                </div>
            <?php endif; ?>
            
            <form action="" method="POST">
                
                <input type="text" id="name" name="name" placeholder="Name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
                <input type="text" id="institution" name="institution" placeholder="Institution" value="<?php echo htmlspecialchars($_POST['institution'] ?? ''); ?>" required>
                <input type="email" id="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                <input type="tel" id="phone" name="phone" placeholder="Phone" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>" required>
                <textarea id="message" name="message" placeholder="Message" rows="6" required><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                
                <button type="submit" class="submit-btn">Submit</button>
            </form>
        </div>
    </section>

    <?php include 'footer.php'; ?>

</body>
</html>