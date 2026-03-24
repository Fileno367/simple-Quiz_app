<?php 
require_once '../config/database.php';
require_once '../includes/functions.php';

if (isset($_POST['reset'])) {
    $email = trim($_POST['email']);

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // Generate secure token
        $token = bin2hex(random_bytes(32));
        $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

        $stmt = $pdo->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)");
        $stmt->execute([$user['id'], $token, $expires]);

        // For development: Show the reset link directly (in real app, send via email)
        $reset_link = "http://localhost/edquiz/student/reset-password.php?token=" . $token;
        
        $success = "Password reset link generated.<br>
                    <strong>Click here to reset:</strong><br>
                    <a href='$reset_link' class='text-blue-600 underline break-all'>$reset_link</a><br><br>
                    <small>(In production, this link would be emailed to you)</small>";
    } else {
        $error = "No account found with this email.";
    }
}
?>
<?php include '../includes/header.php'; ?>

<div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
    <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8">
        <h2 class="text-3xl font-bold text-center mb-8">Forgot Password</h2>
        
        <?php if (isset($error)): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded-2xl mb-6"><?= $error ?></div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-6"><?= $success ?></div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-medium mb-2">Enter your registered email</label>
                <input type="email" name="email" required 
                       class="w-full px-5 py-4 rounded-2xl border focus:outline-none focus:border-indigo-500">
            </div>

            <button type="submit" name="reset"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-4 rounded-2xl transition">
                Send Reset Link
            </button>
        </form>

        <p class="text-center mt-6">
            <a href="login.php" class="text-indigo-600">Back to Login</a>
        </p>
    </div>
</div>

<?php include '../includes/footer.php'; ?>