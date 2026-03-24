<?php 

require_once '../config/database.php';
require_once '../includes/functions.php';

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

<div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
    <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8">
        <h2 class="text-3xl font-bold text-center mb-8 text-red-600">Admin Login</h2>
        
        <?php if (isset($error)): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded-2xl mb-6"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-medium mb-2">Username</label>
                <input type="text" name="username" value="admin" required 
                       class="w-full px-5 py-4 rounded-2xl border focus:outline-none focus:border-red-500">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Password</label>
                <input type="password" name="password" value="admin123" required 
                       class="w-full px-5 py-4 rounded-2xl border focus:outline-none focus:border-red-500">
            </div>

            <button type="submit" name="login"
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-4 rounded-2xl transition">
                Admin Login
            </button>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>