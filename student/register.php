<?php 
require_once '../config/database.php';
require_once '../includes/functions.php';

if (isset($_POST['register'])) {
    $username  = trim($_POST['username']);
    $email     = trim($_POST['email']);
    $full_name = trim($_POST['full_name']);
    $password  = $_POST['password'];
    $confirm   = $_POST['confirm_password'];

    if ($password !== $confirm) {
        $error = "Passwords do not match!";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("INSERT INTO users (username, email, full_name, password) VALUES (?, ?, ?, ?)");
        try {
            $stmt->execute([$username, $email, $full_name, $hashed]);
            $success = "Registration successful! <a href='login.php' class='text-blue-400 underline'>Login here</a>";
        } catch (PDOException $e) {
            $error = "Username or Email already exists!";
        }
    }
}
?>
<?php include '../includes/header.php'; ?>

<div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
    <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8">
        <h2 class="text-3xl font-bold text-center mb-8">Create Student Account</h2>
        
        <?php if (isset($error)): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded-2xl mb-6"><?= $error ?></div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-6"><?= $success ?></div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-medium mb-2">Full Name</label>
                <input type="text" name="full_name" required 
                       class="w-full px-5 py-4 rounded-2xl border focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Username</label>
                <input type="text" name="username" required 
                       class="w-full px-5 py-4 rounded-2xl border focus:outline-none focus:border-indigo-500">
            </div>
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
            <div>
                <label class="block text-sm font-medium mb-2">Confirm Password</label>
                <input type="password" name="confirm_password" required 
                       class="w-full px-5 py-4 rounded-2xl border focus:outline-none focus:border-indigo-500">
            </div>

            <button type="submit" name="register"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-4 rounded-2xl transition">
                Register
            </button>
        </form>

        <p class="text-center mt-6">
            Already have an account? <a href="login.php" class="text-indigo-600 font-medium">Login here</a>
        </p>
    </div>
</div>

<?php include '../includes/footer.php'; ?>