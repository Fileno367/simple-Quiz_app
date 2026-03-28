<?php 
// student/register.php
require_once '../config/database.php';
require_once '../includes/functions.php';

if (isset($_POST['register'])) {
    $username   = sanitize($_POST['username']);
    $email      = sanitize($_POST['email']);
    $full_name  = sanitize($_POST['full_name']);
    $password   = $_POST['password'];
    $confirm    = $_POST['confirm_password'];

    if ($password !== $confirm) {
        $error = "Passwords do not match!";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters!";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("INSERT INTO users (username, email, full_name, password) VALUES (?, ?, ?, ?)");
        try {
            $stmt->execute([$username, $email, $full_name, $hashed]);
            $success = "Registration successful! You can now <a href='login.php'>login</a>.";
        } catch (PDOException $e) {
            $error = "Username or Email already exists!";
        }
    }
}
?>
<?php include '../includes/header.php'; ?>

<div class="card" style="max-width: 500px; margin: 40px auto;">
    <h2 style="text-align:center; margin-bottom:25px;">Student Registration</h2>
    
    <?php if (isset($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>
    
    <?php if (isset($success)): ?>
        <div class="success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST">
        <div style="margin-bottom:15px;">
            <label style="display:block; margin-bottom:5px;">Full Name</label>
            <input type="text" name="full_name" required 
                   style="width:100%; padding:12px; border:1px solid #ccc; border-radius:5px;">
        </div>
        
        <div style="margin-bottom:15px;">
            <label style="display:block; margin-bottom:5px;">Username</label>
            <input type="text" name="username" required 
                   style="width:100%; padding:12px; border:1px solid #ccc; border-radius:5px;">
        </div>
        
        <div style="margin-bottom:15px;">
            <label style="display:block; margin-bottom:5px;">Email</label>
            <input type="email" name="email" required 
                   style="width:100%; padding:12px; border:1px solid #ccc; border-radius:5px;">
        </div>
        
        <div style="margin-bottom:15px;">
            <label style="display:block; margin-bottom:5px;">Password</label>
            <input type="password" name="password" required 
                   style="width:100%; padding:12px; border:1px solid #ccc; border-radius:5px;">
        </div>
        
        <div style="margin-bottom:20px;">
            <label style="display:block; margin-bottom:5px;">Confirm Password</label>
            <input type="password" name="confirm_password" required 
                   style="width:100%; padding:12px; border:1px solid #ccc; border-radius:5px;">
        </div>

        <button type="submit" name="register" 
                class="btn btn-primary" style="width:100%; padding:14px; font-size:18px;">
            Register
        </button>
    </form>

    <p style="text-align:center; margin-top:20px;">
        Already have an account? <a href="login.php">Login here</a>
    </p>
</div>

<?php include '../includes/footer.php'; ?>