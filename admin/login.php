<?php 
// admin/login.php
require_once '../config/database.php';
require_once '../includes/functions.php';

$error = "";

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id']   = $admin['id'];
        $_SESSION['admin_user'] = $admin['username'];
        
        redirect('dashboard.php');
    } else {
        $error = "Invalid admin credentials!";
    }
}
?>
<?php include '../includes/header.php'; ?>

<div class="card" style="max-width: 450px; margin: 50px auto;">
    <h2 style="text-align:center; margin-bottom:25px; color:#dc3545;">Admin Login</h2>
    
    <?php if (!empty($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div style="margin-bottom:15px;">
            <label style="display:block; margin-bottom:5px;">Username</label>
            <input type="text" name="username" value="admin" required
                   style="width:100%; padding:12px; border:1px solid #ccc; border-radius:5px;">
        </div>
        
        <div style="margin-bottom:20px;">
            <label style="display:block; margin-bottom:5px;">Password</label>
            <input type="password" name="password" value="admin123" required
                   style="width:100%; padding:12px; border:1px solid #ccc; border-radius:5px;">
        </div>

        <button type="submit" name="login"
                class="btn btn-primary" style="width:100%; padding:14px; font-size:18px;">
            Login as Admin
        </button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>