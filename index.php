<?php 
// index.php
require_once 'config/database.php';
require_once 'includes/functions.php';
?>
<?php include 'includes/header.php'; ?>

<div style="min-height: 90vh; display: flex; align-items: center; justify-content: center; 
            background: linear-gradient(to right, #007bff, #0056b3); color: white;">
    
    <div class="container" style="text-align: center; padding: 40px 20px;">
        <h1 style="font-size: 58px; font-weight: bold; margin-bottom: 20px;">EduQuiz</h1>
        <p style="font-size: 24px; margin-bottom: 50px; max-width: 700px; margin-left: auto; margin-right: auto;">
            Learn Smarter • Test Better • Improve Faster
        </p>
        
        <div style="display: flex; flex-wrap: wrap; gap: 30px; justify-content: center;">
            
            <!-- Student Section -->
            <div style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); 
                        padding: 40px; border-radius: 12px; width: 320px; border: 1px solid rgba(255,255,255,0.3);">
                <h2 style="font-size: 26px; margin-bottom: 25px;">I am a Student</h2>
                
                <a href="student/login.php" 
                   class="btn btn-primary" 
                   style="width: 100%; display: block; margin-bottom: 15px; padding: 16px; font-size: 18px;">
                    Student Login
                </a>
                
                <a href="student/register.php" 
                   class="btn" 
                   style="width: 100%; display: block; background: transparent; border: 2px solid white; color: white; padding: 16px; font-size: 18px;">
                    Create New Account
                </a>
            </div>

            <!-- Admin Section -->
            <div style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); 
                        padding: 40px; border-radius: 12px; width: 320px; border: 1px solid rgba(255,255,255,0.3);">
                <h2 style="font-size: 26px; margin-bottom: 25px;">Admin Portal</h2>
                
                <a href="admin/login.php" 
                   class="btn btn-primary" 
                   style="width: 100%; display: block; padding: 16px; font-size: 18px;">
                    Admin Login
                </a>
            </div>
            
        </div>

        <p style="margin-top: 60px; opacity: 0.85; font-size: 15px;">
            Built for students • Powered by PHP &amp; MySQL
        </p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>