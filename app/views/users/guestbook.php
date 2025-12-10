<?php
$lang = $_SESSION['lang'] ?? 'en';

$guestTrans = array(
    'en' => array(
        'page_title' => 'Guestbook',
        'form_title' => 'Guestbook',
        'name' => 'Name',
        'institution' => 'Institution',
        'email' => 'Email',
        'phone' => 'Phone',
        'message' => 'Message',
        'submit' => 'Submit',
        'success_msg' => 'Thank you! Your message has been sent.',
        'error_msg' => 'Failed to send message. Please try again.',
        'error_required' => 'All fields are required!'
    ),
    'id' => array(
        'page_title' => 'Buku Tamu',
        'form_title' => 'Buku Tamu',
        'name' => 'Nama',
        'institution' => 'Institusi',
        'email' => 'Email',
        'phone' => 'Telepon',
        'message' => 'Pesan',
        'submit' => 'Kirim',
        'success_msg' => 'Terima kasih! Pesan Anda sudah dikirim.',
        'error_msg' => 'Gagal mengirim pesan. Silakan coba lagi.',
        'error_required' => 'Semua field harus diisi!'
    )
);
$gt = $guestTrans[$lang];

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
            $errorMessage = $gt['error_required'];
        } else {
            // Insert to database
            if ($guestbookModel->create($data)) {
                $successMessage = $gt['success_msg'];
                // Clear form
                $_POST = [];
            } else {
                $errorMessage = $gt['error_msg'];
            }
        }
    } catch (Exception $e) {
        error_log("Guestbook Error: " . $e->getMessage());
        $errorMessage = 'Error: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $gt['page_title']; ?> - Learning Engineering Technology</title>
    
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
        
        <h1 class="form-title gradient-text"><?php echo $gt['form_title']; ?></h1>
        
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
                
                <input type="text" id="name" name="name" placeholder="<?php echo $gt['name']; ?>" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
                <input type="text" id="institution" name="institution" placeholder="<?php echo $gt['institution']; ?>" value="<?php echo htmlspecialchars($_POST['institution'] ?? ''); ?>" required>
                <input type="email" id="email" name="email" placeholder="<?php echo $gt['email']; ?>" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                <input type="tel" id="phone" name="phone" placeholder="<?php echo $gt['phone']; ?>" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>" required>
                <textarea id="message" name="message" placeholder="<?php echo $gt['message']; ?>" rows="6" required><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                
                <button type="submit" class="submit-btn"><?php echo $gt['submit']; ?></button>
            </form>
        </div>
    </section>

    <?php include 'footer.php'; ?>

</body>
</html>