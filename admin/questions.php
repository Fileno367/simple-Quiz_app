<?php 
// admin/questions.php
 
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

if (!isAdminLoggedIn()) {
    redirect('../admin/login.php');
}

// Add new question
if (isset($_POST['add_question'])) {
    $category_id   = (int)$_POST['category_id'];
    $question_text = sanitize($_POST['question_text']);
    $option_a      = sanitize($_POST['option_a']);
    $option_b      = sanitize($_POST['option_b']);
    $option_c      = sanitize($_POST['option_c']);
    $option_d      = sanitize($_POST['option_d']);
    $correct       = strtoupper($_POST['correct_option']);
    $explanation   = sanitize($_POST['explanation']);

    $stmt = $pdo->prepare("INSERT INTO questions 
        (category_id, question_text, option_a, option_b, option_c, option_d, correct_option, explanation) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->execute([$category_id, $question_text, $option_a, $option_b, $option_c, $option_d, $correct, $explanation]);
    $success = "Question added successfully!";
}
?>
<?php include '../includes/header.php'; ?>

<h2>Manage Questions</h2>

<?php if (isset($success)): ?>
    <div class="success"><?= $success ?></div>
<?php endif; ?>

<div class="card">
    <h3>Add New Question</h3>
    <form method="POST">
        <div style="margin-bottom:15px;">
            <label>Category</label><br>
            <select name="category_id" required style="width:100%; padding:10px;">
                <?php
                $cats = $pdo->query("SELECT * FROM categories")->fetchAll();
                foreach ($cats as $c) {
                    echo "<option value='{$c['id']}'>" . htmlspecialchars($c['name']) . "</option>";
                }
                ?>
            </select>
        </div>
        
        <div style="margin-bottom:15px;">
            <label>Question Text</label><br>
            <textarea name="question_text" rows="3" required style="width:100%; padding:10px;"></textarea>
        </div>
        
        <div style="margin-bottom:10px;">
            <label>Option A</label>
            <input type="text" name="option_a" required style="width:100%; padding:10px;">
        </div>
        <div style="margin-bottom:10px;">
            <label>Option B</label>
            <input type="text" name="option_b" required style="width:100%; padding:10px;">
        </div>
        <div style="margin-bottom:10px;">
            <label>Option C</label>
            <input type="text" name="option_c" required style="width:100%; padding:10px;">
        </div>
        <div style="margin-bottom:15px;">
            <label>Option D</label>
            <input type="text" name="option_d" required style="width:100%; padding:10px;">
        </div>
        
        <div style="margin-bottom:15px;">
            <label>Correct Option (A/B/C/D)</label><br>
            <input type="text" name="correct_option" maxlength="1" required style="width:100%; padding:10px; text-transform:uppercase;">
        </div>
        
        <div style="margin-bottom:20px;">
            <label>Explanation (optional)</label><br>
            <textarea name="explanation" rows="2" style="width:100%; padding:10px;"></textarea>
        </div>
        
        <button type="submit" name="add_question" class="btn btn-primary">Add Question</button>
    </form>
</div>

<a href="dashboard.php" class="btn btn-primary" style="margin-top:20px;">Back to Dashboard</a>

<?php include '../includes/footer.php'; ?>