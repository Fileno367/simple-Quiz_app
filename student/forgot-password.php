<?php 
// student/forgot-password.php
require_once '../config/database.php';
require_once '../includes/functions.php';

if (isset($_POST['send_reset'])) {
    $email = sanitize($_POST['email']);

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // Generate secure token
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Save token
        $stmt = $pdo->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)");
        $stmt->execute([$user['id'], $token, $expires]);

        // In real project, send email here. For now, we show the link.
        $reset_link = "http://localhost/edquiz/student/reset-password.php?token=" . $token;
        
        $success = "Password reset link has been generated.<br>
                    <strong>Click here to reset:</strong><br>
                    <a href='$reset_link'>$reset_link</a><br><br>
                    (In production, this link would be sent to your email)";
    } else {
        $error = "No account found with this email!";
    }
}
?>
<?php include '../includes/header.php'; ?>

<div class="card" style="max-width: 500px; margin: 40px auto;">
    <h2 style="text-align:center; margin-bottom:25px;">Forgot Password</h2>
    
    <?php if (isset($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>
    
    <?php if (isset($success)): ?>
        <div class="success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST">
        <div style="margin-bottom:20px;">
            <label style="display:block; margin-bottom:5px;">Enter your registered Email</label>
            <input type="email" name="email" required 
                   style="width:100%; padding:12px; border:1px solid #ccc; border-radius:5px;">
        </div>

        <button type="submit" name="send_reset" 
                class="btn btn-primary" style="width:100%; padding:14px;">
            Send Reset Link
        </button>
    </form>

    <p style="text-align:center; margin-top:20px;">
        <a href="login.php">Back to Login</a>
    </p>
</div>

<?php include '../includes/footer.php'; ?>