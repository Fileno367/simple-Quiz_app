<?php 
require_once '../config/database.php';
require_once '../includes/functions.php';

if (isset($_POST['login'])) {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['username']  = $user['username'];
        $_SESSION['full_name'] = $user['full_name'];
        redirect('../student/dashboard.php');
    } else {
        $error = "Invalid email or password!";
    }
}
?>
<?php include '../includes/header.php'; ?>

<div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
    <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8">
        <h2 class="text-3xl font-bold text-center mb-8">Student Login</h2>
        
        <?php if (isset($error)): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded-2xl mb-6"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-medium mb-2">Email</label>
                <input type="email" name="email" required 
                       class="w-full px-5 py-4 rounded-2xl border focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Password</label>
                <input type="password" name="password" required 
                       class="w-full px-5 py-4 rounded-2xl border focus:outline-none focus:border-indigo-500">
            </div>

            <div class="flex justify-between text-sm">
                <a href="forgot-password.php" class="text-indigo-600 hover:underline">Forgot Password?</a>
            </div>

            <button type="submit" name="login"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-4 rounded-2xl transition">
                Login
            </button>
        </form>

        <p class="text-center mt-6">
            Don't have an account? <a href="register.php" class="text-indigo-600 font-medium">Register here</a>
        </p>
    </div>
</div>

<?php include '../includes/footer.php'; ?>