<?php 

session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

if (!isLoggedIn()) {
    redirect('../student/login.php');
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'] ?? 'Student';

// Fetch total quizzes taken and average score
$stmt = $pdo->prepare("SELECT COUNT(*) as total_quizzes, AVG(score) as avg_score 
                       FROM quiz_results WHERE user_id = ?");
$stmt->execute([$user_id]);
$stats = $stmt->fetch();
?>
<?php include '../includes/header.php'; ?>

<h2>Welcome, <?= htmlspecialchars($username) ?>!</h2>
<p style="margin-bottom:30px;">Ready to test your knowledge?</p>

<div class="card">
    <h3>Your Progress</h3>
    <p><strong>Total Quizzes Taken:</strong> <?= $stats['total_quizzes'] ?? 0 ?></p>
    <p><strong>Average Score:</strong> <?= $stats['avg_score'] ? round($stats['avg_score'], 1) . '%' : 'No quizzes yet' ?></p>
</div>

<div class="card" style="margin-top:20px;">
    <h3>Available Subjects</h3>
    <p style="margin-bottom:20px;">Choose a subject to start a quiz:</p>
    
    <?php
    $stmt = $pdo->query("SELECT * FROM categories ORDER BY name");
    $categories = $stmt->fetchAll();
    
    if (empty($categories)) {
        echo "<p>No subjects available yet. Ask your admin to add some categories and questions.</p>";
    } else {
        echo '<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 15px;">';
        foreach ($categories as $cat) {
            echo '
            <div style="border:1px solid #ddd; padding:20px; border-radius:8px;">
                <h4>' . htmlspecialchars($cat['name']) . '</h4>
                <p style="color:#666; font-size:14px;">' . htmlspecialchars($cat['description'] ?? '') . '</p>
                <a href="quiz.php?category_id=' . $cat['id'] . '" 
                   class="btn btn-primary" style="margin-top:15px; display:inline-block;">
                    Start Quiz
                </a>
            </div>';
        }
        echo '</div>';
    }
    ?>
</div>

<p style="margin-top:30px;">
    <a href="../logout.php" class="btn btn-danger">Logout</a>
</p>

<?php include '../includes/footer.php'; ?>