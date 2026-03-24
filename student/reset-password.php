<?php 
require_once '../config/database.php';
require_once '../includes/functions.php';

if (!isset($_GET['token'])) {
    die("Invalid request.");
}

$token = $_GET['token'];

$stmt = $pdo->prepare("SELECT user_id, expires_at FROM password_resets WHERE token = ? AND expires_at > NOW()");
$stmt->execute([$token]);
$reset = $stmt->fetch();

if (!$reset) {
    die("Invalid or expired token.");
}

if (isset($_POST['update_password'])) {
    $new_password = $_POST['new_password'];
    $confirm      = $_POST['confirm_password'];

    if ($new_password === $confirm) {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$hashed, $reset['user_id']]);

        // Delete used token
        $pdo->prepare("DELETE FROM password_resets WHERE token = ?")->execute([$token]);

        $success = "Password updated successfully! <a href='login.php' class='text-blue-600 underline'>Login now</a>";
    } else {
        $error = "Passwords do not match.";
    }
}
?>
<?php include '../includes/header.php'; ?>

<div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
    <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8">
        <h2 class="text-3xl font-bold text-center mb-8">Reset Your Password</h2>
        
        <?php if (isset($error)): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded-2xl mb-6"><?= $error ?></div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-6"><?= $success ?></div>
        <?php endif; ?>

        <?php if (!isset($success)): ?>
        <form method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-medium mb-2">New Password</label>
                <input type="password" name="new_password" required 
                       class="w-full px-5 py-4 rounded-2xl border focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Confirm New Password</label>
                <input type="password" name="confirm_password" required 
                       class="w-full px-5 py-4 rounded-2xl border focus:outline-none focus:border-indigo-500">
            </div>

            <button type="submit" name="update_password"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-4 rounded-2xl transition">
                Update Password
            </button>
        </form>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>