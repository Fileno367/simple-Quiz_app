<?php
// student/submit-quiz.php
require_once '../config/database.php';
require_once '../includes/functions.php';

if (!isLoggedIn()) {
    echo json_encode(['status' => 'error']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id      = $_SESSION['user_id'];
    $category_id  = (int)$_POST['category_id'];
    $score        = (int)$_POST['score'];
    $total        = (int)$_POST['total_questions'];
    $time_taken   = (int)$_POST['time_taken'];

    $stmt = $pdo->prepare("INSERT INTO quiz_results (user_id, category_id, score, total_questions, time_taken) 
                           VALUES (?, ?, ?, ?, ?)");
    
    if ($stmt->execute([$user_id, $category_id, $score, $total, $time_taken])) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
} else {
    echo json_encode(['status' => 'error']);
}
?>