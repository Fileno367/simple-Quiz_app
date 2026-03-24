<?php 
require_once 'config/database.php';
require_once 'includes/functions.php';
?>
<?php include 'includes/header.php'; ?>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-600 to-indigo-700">
    <div class="tail-container px-6 py-12">
        <div class="max-w-2xl mx-auto text-center text-white">
            <h1 class="text-6xl font-bold mb-6">EduQuiz</h1>
            <p class="text-2xl mb-10">Learn Smarter • Test Better • Improve Faster</p>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <!-- Student Section -->
                <div class="bg-white/10 backdrop-blur-lg p-8 rounded-3xl border border-white/20 w-full sm:w-80">
                    <h2 class="text-2xl font-semibold mb-6">I am a Student</h2>
                    <a href="student/login.php" 
                       class="block w-full bg-white text-indigo-700 font-semibold py-4 rounded-2xl hover:bg-gray-100 transition">
                        Student Login
                    </a>
                    <a href="student/register.php" 
                       class="block w-full mt-4 border border-white/70 text-white font-medium py-4 rounded-2xl hover:bg-white/10 transition">
                        Create New Account
                    </a>
                </div>

                <!-- Admin Section -->
                <div class="bg-white/10 backdrop-blur-lg p-8 rounded-3xl border border-white/20 w-full sm:w-80">
                    <h2 class="text-2xl font-semibold mb-6">Admin Portal</h2>
                    <a href="admin/login.php" 
                       class="block w-full bg-gray text-indigo-700 font-semibold py-4 rounded-2xl hover:bg-gray-100 transition">
                        Admin Login
                    </a>
                </div>
            </div>

            <p class="mt-12 text-sm opacity-75">Built for students • Powered by PHP &amp; MySQL</p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>