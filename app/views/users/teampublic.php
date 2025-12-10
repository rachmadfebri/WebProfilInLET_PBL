<?php
$lang = $_SESSION['lang'] ?? 'en';

$teamTrans = array(
    'en' => array(
        'page_title' => 'Team',
        'label' => 'Our Team',
        'title' => 'Meet Our Team',
        'subtitle' => 'A multidisciplinary team combining education researchers, engineers, and visual designers to execute innovative and impactful modern learning ideas.',
        'leadership' => 'Leadership Team',
        'members' => 'Team Members',
        'no_team_title' => 'No Team Data Yet',
        'no_team_desc' => 'Team member information will be added soon.'
    ),
    'id' => array(
        'page_title' => 'Tim',
        'label' => 'Tim Kami',
        'title' => 'Temui Tim Kami',
        'subtitle' => 'Tim multidisiplin yang menggabungkan peneliti pendidikan, engineer, dan visual designer untuk mengeksekusi gagasan pembelajaran modern yang inovatif dan berdampak.',
        'leadership' => 'Tim Pimpinan',
        'members' => 'Anggota Tim',
        'no_team_title' => 'Belum Ada Data Tim',
        'no_team_desc' => 'Informasi anggota tim akan segera ditambahkan.'
    )
);
$tt = $teamTrans[$lang];

// Ambil data tim dari database
require_once __DIR__ . '/../../model/teamMembersModel.php';
require_once __DIR__ . '/../../../config/database.php';

$database = new Database();
$pdo = $database->connect();

try {
    $teamMembersModel = new TeamMembersModel($pdo);
    $teamList = $teamMembersModel->getAll();
} catch (Exception $e) {
    error_log("Team Error: " . $e->getMessage());
    $teamList = [];
}
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $tt['page_title']; ?> - Learning Engineering Technology</title>

    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="page page-team">

    <?php include 'header.php'; ?>

    <main class="page-wrapper">
        <div class="team-page">
            
            <div class="team-header">
                <div class="team-label"><?php echo $tt['label']; ?></div>
                <h1 class="team-title"><?php echo $tt['title']; ?></h1>
                <p class="team-subtitle">
                    <?php echo $tt['subtitle']; ?>
                </p>
            </div>

            <?php if (!empty($teamList)): ?>
                
                <?php 
                // Separate leaders and members
                $leaders = [];
                $members = [];
                
                foreach ($teamList as $person) {
                    $position = strtolower($person['position'] ?? '');
                    if (strpos($position, 'leader') !== false || strpos($position, 'head') !== false || strpos($position, 'director') !== false) {
                        $leaders[] = $person;
                    } else {
                        $members[] = $person;
                    }
                }
                ?>

                <?php if (!empty($leaders)): ?>
                <section class="leadership-section">
                    <h2 class="section-title"><?php echo $tt['leadership']; ?></h2>
                    <div class="leadership-grid">
                        <?php foreach ($leaders as $leader): ?>
                            <article class="leader-card">
                                <div class="leader-avatar">
                                    <?php if (!empty($leader['photo'])): ?>
                                        <img src="<?php echo htmlspecialchars($leader['photo']); ?>" 
                                             alt="<?php echo htmlspecialchars($leader['name']); ?>">
                                    <?php else: ?>
                                        <div class="team-avatar-placeholder">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="team-info">
                                    <h3 class="team-name"><?php echo htmlspecialchars($leader['name']); ?></h3>
                                    <p class="team-position"><?php echo htmlspecialchars($leader['position']); ?></p>
                                </div>
                                <div class="team-social">
                                    <?php if (!empty($leader['email'])): ?>
                                        <a href="mailto:<?php echo htmlspecialchars($leader['email']); ?>" title="Email">
                                            <i class="fas fa-envelope"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($leader['google_scholar'])): ?>
                                        <?php 
                                        $scholarUrl = $leader['google_scholar'];
                                        if (!preg_match('/^https?:\/\//', $scholarUrl)) {
                                            $scholarUrl = 'https://' . $scholarUrl;
                                        }
                                        ?>
                                        <a href="<?php echo htmlspecialchars($scholarUrl); ?>" target="_blank" title="Google Scholar">
                                            <i class="fas fa-graduation-cap"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($leader['twitter'])): ?>
                                        <?php 
                                        $twitterUrl = $leader['twitter'];
                                        if (!preg_match('/^https?:\/\//', $twitterUrl)) {
                                            $twitterUrl = 'https://twitter.com/' . ltrim($twitterUrl, '@');
                                        }
                                        ?>
                                        <a href="<?php echo htmlspecialchars($twitterUrl); ?>" target="_blank" title="Twitter">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($leader['instagram'])): ?>
                                        <?php 
                                        $igUrl = $leader['instagram'];
                                        if (!preg_match('/^https?:\/\//', $igUrl)) {
                                            $igUrl = 'https://instagram.com/' . ltrim($igUrl, '@');
                                        }
                                        ?>
                                        <a href="<?php echo htmlspecialchars($igUrl); ?>" target="_blank" title="Instagram">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </section>
                <?php endif; ?>

                <?php if (!empty($members)): ?>
                <section class="members-section">
                    <h2 class="section-title"><?php echo $tt['members']; ?></h2>
                    <div class="team-grid">
                        <?php foreach ($members as $member): ?>
                            <article class="team-card">
                                <div class="team-avatar">
                                    <?php if (!empty($member['photo'])): ?>
                                        <img src="<?php echo htmlspecialchars($member['photo']); ?>" 
                                             alt="<?php echo htmlspecialchars($member['name']); ?>">
                                    <?php else: ?>
                                        <div class="team-avatar-placeholder">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="team-info">
                                    <h3 class="team-name"><?php echo htmlspecialchars($member['name']); ?></h3>
                                    <p class="team-position"><?php echo htmlspecialchars($member['position']); ?></p>
                                </div>
                                <div class="team-social">
                                    <?php if (!empty($member['email'])): ?>
                                        <a href="mailto:<?php echo htmlspecialchars($member['email']); ?>" title="Email">
                                            <i class="fas fa-envelope"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($member['google_scholar'])): ?>
                                        <?php 
                                        $scholarUrl = $member['google_scholar'];
                                        if (!preg_match('/^https?:\/\//', $scholarUrl)) {
                                            $scholarUrl = 'https://' . $scholarUrl;
                                        }
                                        ?>
                                        <a href="<?php echo htmlspecialchars($scholarUrl); ?>" target="_blank" title="Google Scholar">
                                            <i class="fas fa-graduation-cap"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($member['twitter'])): ?>
                                        <?php 
                                        $twitterUrl = $member['twitter'];
                                        if (!preg_match('/^https?:\/\//', $twitterUrl)) {
                                            $twitterUrl = 'https://twitter.com/' . ltrim($twitterUrl, '@');
                                        }
                                        ?>
                                        <a href="<?php echo htmlspecialchars($twitterUrl); ?>" target="_blank" title="Twitter">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($member['instagram'])): ?>
                                        <?php 
                                        $igUrl = $member['instagram'];
                                        if (!preg_match('/^https?:\/\//', $igUrl)) {
                                            $igUrl = 'https://instagram.com/' . ltrim($igUrl, '@');
                                        }
                                        ?>
                                        <a href="<?php echo htmlspecialchars($igUrl); ?>" target="_blank" title="Instagram">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </section>
                <?php endif; ?>

            <?php else: ?>
                <div class="no-team-message">
                    <i class="fas fa-users"></i>
                    <h3><?php echo $tt['no_team_title']; ?></h3>
                    <p><?php echo $tt['no_team_desc']; ?></p>
                </div>
            <?php endif; ?>

        </div>
    </main>

    <?php include 'footer.php'; ?>

</body>

</html>
