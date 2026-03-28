<?php 
// student/result.php
require_once '../config/database.php';
require_once '../includes/functions.php';

if (!isLoggedIn()) {
    redirect('../student/login.php');
}

$score = isset($_GET['score']) ? (int)$_GET['score'] : 0;
$total = isset($_GET['total']) ? (int)$_GET['total'] : 10;
$percentage = $total > 0 ? round(($score / $total) * 100) : 0;

// Get category name
$category_id = $_SESSION['current_quiz']['category_id'] ?? 0;
$cat_stmt = $pdo->prepare("SELECT name FROM categories WHERE id = ?");
$cat_stmt->execute([$category_id]);
$category_name = $cat_stmt->fetchColumn() ?? 'Unknown Subject';

unset($_SESSION['current_quiz']); // Clear current quiz session
?>
<?php include '../includes/header.php'; ?>

<div class="card" style="max-width: 600px; margin: 40px auto; text-align:center;">
    <h2>Quiz Completed!</h2>
    
    <div style="font-size:80px; margin:30px 0; color:#007bff;">
        <?= $percentage ?>%
    </div>
    
    <h3><?= $score ?> out of <?= $total ?> correct</h3>
    <p><strong>Subject:</strong> <?= htmlspecialchars($category_name) ?></p>
    <p><strong>Time Taken:</strong> <?= isset($_GET['time']) ? $_GET['time'] : 'N/A' ?> seconds</p>

    <?php if ($percentage >= 80): ?>
        <div class="success" style="font-size:18px;">Excellent! Keep it up! 🎉</div>
    <?php elseif ($percentage >= 60): ?>
        <div class="success" style="font-size:18px;">Good Job!</div>
    <?php else: ?>
        <div class="error" style="font-size:18px;">Keep practicing. You can do better!</div>
    <?php endif; ?>

    <div style="margin:30px 0;">
        <a href="dashboard.php" class="btn btn-primary" style="margin:0 10px;">Take Another Quiz</a>
        <a href="history.php" class="btn btn-primary" style="margin:0 10px;">View History</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>