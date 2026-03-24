<?php 
require_once '../config/database.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    redirect('../student/login.php');
}

$user_id = $_SESSION['user_id'];

// Get total quizzes taken and average score
$stmt = $pdo->prepare("SELECT COUNT(*) as total, AVG(score) as avg_score 
                       FROM quiz_results WHERE user_id = ?");
$stmt->execute([$user_id]);
$stats = $stmt->fetch();
?>
<?php include '../includes/header.php'; ?>

<div class="tail-container px-6 py-10">
    <h1 class="text-4xl font-bold mb-2">Welcome back, <?= htmlspecialchars($_SESSION['full_name'] ?? $_SESSION['username']) ?>!</h1>
    <p class="text-gray-600 dark:text-gray-400 mb-10">Ready to test your knowledge today?</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Stats Cards -->
        <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow">
            <div class="text-5xl font-bold text-indigo-600"><?= $stats['total'] ?? 0 ?></div>
            <div class="text-gray-500 mt-2">Quizzes Taken</div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow">
            <div class="text-5xl font-bold text-indigo-600">
                <?= $stats['avg_score'] ? round($stats['avg_score'], 1) : '0' ?>%
            </div>
            <div class="text-gray-500 mt-2">Average Score</div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow flex items-center justify-center">
            <a href="categories.php" 
               class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-10 py-4 rounded-2xl text-lg transition">
                Start New Quiz →
            </a>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="mt-12">
        <h2 class="text-2xl font-semibold mb-6">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="categories.php" class="block p-8 bg-white dark:bg-gray-800 rounded-3xl shadow hover:shadow-lg transition">
                <h3 class="font-semibold text-xl mb-2">Browse Subjects</h3>
                <p class="text-gray-500">Choose from Mathematics, Science, History and more</p>
            </a>
            <a href="history.php" class="block p-8 bg-white dark:bg-gray-800 rounded-3xl shadow hover:shadow-lg transition">
                <h3 class="font-semibold text-xl mb-2">View Past Results</h3>
                <p class="text-gray-500">Review your previous quiz performance</p>
            </a>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>