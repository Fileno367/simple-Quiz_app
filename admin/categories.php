<?php 
// admin/categories.php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

if (!isAdminLoggedIn()) {
    redirect('../admin/login.php');
}


// Add new category
if (isset($_POST['add_category'])) {
    $name = sanitize($_POST['name']);
    $description = sanitize($_POST['description']);

    $stmt = $pdo->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
    $stmt->execute([$name, $description]);
    $success = "Category added successfully!";
}

// Delete category
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    
    // Optional: also delete related questions
    $stmt = $pdo->prepare("DELETE FROM questions WHERE category_id = ?");
    $stmt->execute([$id]);
    
    $success = "Category and related questions deleted!";
    
    // Redirect to clean URL (prevents refresh re-deleting)
    header("Location: categories.php?success=1");
    exit();
}

if (isset($_GET['success'])) {
    $success = "Category deleted successfully!";
}
?>

<?php include '../includes/header.php'; ?>

<h2>Manage Categories (Subjects)</h2>

<?php if (isset($success)): ?>
    <div class="success"><?= $success ?></div>
<?php endif; ?>

<div class="card">
    <h3>Add New Category</h3>
    <form method="POST" style="margin-bottom:30px;">
        <div style="margin-bottom:15px;">
            <label style="display:block; margin-bottom:5px;">Category Name</label>
            <input type="text" name="name" required 
                   style="width:100%; padding:12px; border:1px solid #ccc; border-radius:5px;">
        </div>
        <div style="margin-bottom:20px;">
            <label style="display:block; margin-bottom:5px;">Description (optional)</label>
            <textarea name="description" rows="3" 
                      style="width:100%; padding:12px; border:1px solid #ccc; border-radius:5px;"></textarea>
        </div>
        <button type="submit" name="add_category" class="btn btn-primary">Add Category</button>
    </form>
</div>

<div class="card">
    <h3>Existing Categories</h3>
    <?php
    $stmt = $pdo->query("SELECT * FROM categories ORDER BY name");
    $categories = $stmt->fetchAll();
    ?>
    
    <?php if (empty($categories)): ?>
        <p>No categories yet.</p>
    <?php else: ?>
        <table style="width:100%; border-collapse:collapse;">
            <tr style="background:#f0f0f0;">
                <th style="padding:12px; text-align:left;">ID</th>
                <th style="padding:12px; text-align:left;">Name</th>
                <th style="padding:12px; text-align:left;">Description</th>
                <th style="padding:12px; text-align:center;">Actions</th>
            </tr>
            <?php foreach ($categories as $cat): ?>
            <tr>
                <td style="padding:12px; border-bottom:1px solid #ddd;"><?= $cat['id'] ?></td>
                <td style="padding:12px; border-bottom:1px solid #ddd;"><?= htmlspecialchars($cat['name']) ?></td>
                <td style="padding:12px; border-bottom:1px solid #ddd;"><?= htmlspecialchars($cat['description'] ?? '') ?></td>
                <td style="padding:12px; border-bottom:1px solid #ddd; text-align:center;">
                    <a href="?delete=<?= $cat['id'] ?>" 
                       onclick="return confirm('Delete this category? All questions inside will also be deleted!')" 
                       class="btn btn-danger" style="padding:6px 12px; font-size:14px;">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

<a href="dashboard.php" class="btn btn-primary" style="margin-top:20px;">Back to Admin Dashboard</a>

<?php include '../includes/footer.php'; ?>