<?php 

session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

$error = "";

if (isset($_POST['login'])) {
    $email    = sanitize($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['username']  = $user['username'];
        $_SESSION['full_name'] = $user['full_name'];
        
        // Important: redirect and STOP execution
        redirect('../student/dashboard.php');
exit;
    } else {
        $error = "Invalid email or password!";
    }
}
?>
<?php include '../includes/header.php'; ?>

<div class="card" style="max-width: 450px; margin: 50px auto;">
    <h2 style="text-align:center; margin-bottom:25px;">Student Login</h2>
    
    <?php if (!empty($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div style="margin-bottom:15px;">
            <label style="display:block; margin-bottom:5px;">Email</label>
            <input type="email" name="email" required 
                   style="width:100%; padding:12px; border:1px solid #ccc; border-radius:5px;">
        </div>
        
        <div style="margin-bottom:20px;">
            <label style="display:block; margin-bottom:5px;">Password</label>
            <input type="password" name="password" required 
                   style="width:100%; padding:12px; border:1px solid #ccc; border-radius:5px;">
        </div>

        <div style="margin-bottom:15px; text-align:right;">
            <a href="forgot-password.php" style="color:#007bff;">Forgot Password?</a>
        </div>

        <button type="submit" name="login" 
                class="btn btn-primary" style="width:100%; padding:14px; font-size:18px;">
            Login
        </button>
    </form>

    <p style="text-align:center; margin-top:20px;">
        Don't have an account? <a href="register.php">Register here</a>
    </p>
</div>

<?php include '../includes/footer.php'; ?>