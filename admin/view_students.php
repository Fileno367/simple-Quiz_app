<?php 
// admin/view_students.php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

if (!isAdminLoggedIn()) {
    redirect('../admin/login.php');
}
?>

<?php include '../includes/header.php'; ?>

<h2>View All Students</h2>

<?php
// Fetch all students
$stmt = $pdo->query("SELECT id, username, email, created_at FROM users ORDER BY created_at DESC");
$students = $stmt->fetchAll();
?>

<div class="card">
    <h3>Registered Students (<?= count($students) ?>)</h3>
    
    <?php if (empty($students)): ?>
        <p>No students registered yet.</p>
    <?php else: ?>
        <table style="width:100%; border-collapse:collapse; margin-top:15px;">
            <tr style="background:#f0f0f0;">
                <th style="padding:12px; text-align:left;">ID</th>
                <th style="padding:12px; text-align:left;">Username</th>
                <th style="padding:12px; text-align:left;">Email</th>
                <th style="padding:12px; text-align:left;">Registered Date</th>
                <th style="padding:12px; text-align:center;">Actions</th>
            </tr>
            <?php foreach ($students as $student): ?>
            <tr>
                <td style="padding:12px; border-bottom:1px solid #ddd;"><?= $student['id'] ?></td>
                <td style="padding:12px; border-bottom:1px solid #ddd;"><?= htmlspecialchars($student['username']) ?></td>
                <td style="padding:12px; border-bottom:1px solid #ddd;"><?= htmlspecialchars($student['email'] ?? 'N/A') ?></td>
                <td style="padding:12px; border-bottom:1px solid #ddd;"><?= date('M j, Y', strtotime($student['created_at'])) ?></td>
                <td style="padding:12px; border-bottom:1px solid #ddd; text-align:center;">
                    <a href="#" class="btn btn-danger" style="padding:5px 10px; font-size:14px;"
                       onclick="return confirm('Delete this student?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

<a href="dashboard.php" class="btn btn-primary" style="margin-top:20px;">← Back to Dashboard</a>

<?php include '../includes/footer.php'; ?>