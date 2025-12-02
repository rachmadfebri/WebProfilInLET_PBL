<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team • Learning Engineering Technology</title>

    <!-- Base styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="page page-team">

    <?php include 'header.php'; ?>

    <main class="page-wrapper team-page">
        <div class="page-heading">
            <p class="page-label">Core Members</p>
            <h1 class="page-title gradient-text">Team</h1>
            <p class="page-subtitle">
                Tim multidisiplin yang menggabungkan peneliti pendidikan, engineer, dan visual designer untuk
                mengeksekusi gagasan pembelajaran modern.
            </p>
        </div>

        <section class="team-grid">
            <?php if (!empty($teamList)): ?>
                <?php foreach ($teamList as $member): ?>
                    <article class="team-card">
                        <div class="team-avatar">
                            <?php if (!empty($member['photo'])): ?>
                                <img
                                    src="<?php echo htmlspecialchars($member['photo']); ?>"
                                    alt="<?php echo htmlspecialchars($member['name']); ?>"
                                    style="width:175px;height:150px;border-radius:inherit;object-fit:cover;"
                                >
                            <?php else: ?>
                                <div class="team-avatar-placeholder">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="team-info">
                            <h3 class="team-name">
                                <?php echo htmlspecialchars($member['name']); ?>
                            </h3>
                            <p class="team-position">
                                <?php echo htmlspecialchars($member['position']); ?>
                            </p>

                            <?php if (!empty($member['created_at'])): ?>
                                <p class="team-meta">
                                    Bergabung sejak
                                    <?php echo date('d M Y', strtotime($member['created_at'])); ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <div class="team-social">
                            <?php if (!empty($member['email'])): ?>
                                <a href="mailto:<?php echo htmlspecialchars($member['email']); ?>"
                                   title="Email">
                                    <img src="assets/img/icons/email.png" alt="Email" class="team-social-icon" style="width:20px;height:20px;object-fit:cover;">
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($member['google_scholar'])): ?>
                                <a href="<?php echo htmlspecialchars($member['google_scholar']); ?>"
                                   target="_blank" rel="noopener noreferrer"
                                   title="Google Scholar">
                                    <img src="assets/img/icons/google-scholar.png" alt="Google Scholar" class="team-social-icon" style="width:20px;height:20px;object-fit:cover;">
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($member['twitter'])): ?>
                                <a href="<?php echo htmlspecialchars($member['twitter']); ?>"
                                   target="_blank" rel="noopener noreferrer"
                                   title="Twitter / X">
                                    <img src="assets/img/icons/twitter.png" alt="Twitter" class="team-social-icon" style="width:20px;height:20px;object-fit:cover;">
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($member['instagram'])): ?>
                                <a href="<?php echo htmlspecialchars($member['instagram']); ?>"
                                   target="_blank" rel="noopener noreferrer"
                                   title="Instagram">
                                   <img src="assets/img/icons/instagram.png" alt="Instagram" class="team-social-icon" style="width:20px;height:20px;object-fit:cover;">
                                </a>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align: center;">Belum ada data anggota tim yang tersimpan.</p>
            <?php endif; ?>
        </section>
    </main>

    <?php include 'footer.php'; ?>

</body>

</html>