<?php 
// admin/dashboard.php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

if (!isAdminLoggedIn()) {
    redirect('../admin/login.php');
}

?>
<?php include '../includes/header.php'; ?>

<h2>Admin Dashboard - Advanced Analytics</h2>

<div class="card">
    <h3>Overview</h3>
    <?php
    $total_students = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $total_quizzes  = $pdo->query("SELECT COUNT(*) FROM quiz_results")->fetchColumn();
    $total_questions = $pdo->query("SELECT COUNT(*) FROM questions")->fetchColumn();
    
    $avg_score = $pdo->query("SELECT ROUND(AVG(score), 1) FROM quiz_results")->fetchColumn() ?? 0;
    ?>
    
    <p><strong>Total Students:</strong> <?= $total_students ?></p>
    <p><strong>Total Quizzes Taken:</strong> <?= $total_quizzes ?></p>
    <p><strong>Total Questions in Database:</strong> <?= $total_questions ?></p>
    <p><strong>Average Score Across All Quizzes:</strong> <?= $avg_score ?>%</p>
</div>

<div class="card" style="margin-top:25px;">
    <h3>Quick Actions</h3>
    <p>
        <a href="categories.php" class="btn btn-primary" style="margin-right:10px;">Manage Categories</a>
        <a href="questions.php" class="btn btn-primary" style="margin-right:10px;">Manage Questions</a>
        <a href="view_students.php" class="btn btn-primary">View Students</a>
    </p>
</div>

<p style="margin-top:30px;">
    <a href="../logout.php" class="btn btn-danger">Logout</a>
</p>

<?php include '../includes/footer.php'; ?>