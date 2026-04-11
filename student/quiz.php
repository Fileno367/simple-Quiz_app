<?php 
// student/quiz.php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

if (!isLoggedIn()) {
    redirect('../student/login.php');
}

$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;

if ($category_id <= 0) {
    redirect('dashboard.php');
}

// Get category name
$stmt = $pdo->prepare("SELECT name FROM categories WHERE id = ?");
$stmt->execute([$category_id]);
$category = $stmt->fetch();

if (!$category) {
    die("Category not found!");
}

// Fetch 10 random questions
$stmt = $pdo->prepare("SELECT * FROM questions WHERE category_id = ? ORDER BY RAND() LIMIT 10");
$stmt->execute([$category_id]);
$questions = $stmt->fetchAll();

if (empty($questions)) {
    echo "<h2>No questions available in this category yet.</h2>";
    exit;
}

// Store quiz in session
$_SESSION['current_quiz'] = [
    'category_id' => $category_id,
    'questions'   => $questions,
    'start_time'  => time()
];
?>

<?php include '../includes/header.php'; ?>

<div style="max-width: 900px; margin: 30px auto;">
    <h2><?= htmlspecialchars($category['name']) ?> Quiz</h2>
    <p>You have 10 questions. Total time: <strong>60 minutes</strong></p>

    <!-- Countdown Timer -->
    <div style="text-align:center; margin:20px 0; font-size:22px; font-weight:bold;">
        Time Remaining: 
        <span id="countdown" style="color:#d9534f;">60:00</span>
    </div>

    <div class="card">
        <div id="question-area"></div>

        <!-- Navigation -->
        <div style="margin-top:25px; display:flex; justify-content:space-between; align-items:center;">
            <button onclick="prevQuestion()" id="btn-prev" class="btn btn-primary" style="padding:12px 25px;">
                ← Previous
            </button>
            
            <button onclick="nextQuestion()" id="btn-next" class="btn btn-primary" style="padding:12px 25px;">
                Next →
            </button>
        </div>

        <!-- Submit Button -->
        <div style="text-align:center; margin-top:30px;">
            <button onclick="submitQuiz()" class="btn btn-danger" style="padding:14px 40px; font-size:18px;">
                Submit Quiz & See Results
            </button>
        </div>
    </div>
</div>

<script>
let questions = <?= json_encode($questions) ?>;
let currentIndex = 0;
let userAnswers = {}; 
let totalTime = 3600; // 60 minutes in seconds (1 hour)

// Countdown Timer
function startCountdown() {
    let timeLeft = totalTime;

    const timerInterval = setInterval(() => {
        timeLeft--;
        
        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;
        let display = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        
        document.getElementById('countdown').textContent = display;

        // Turn red when less than 5 minutes
        if (timeLeft <= 300) {
            document.getElementById('countdown').style.color = '#d9534f';
        }

        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            alert("Time's up! Submitting your quiz automatically.");
            submitQuiz(true); // auto submit
        }
    }, 1000);
}

function loadQuestion() {
    const q = questions[currentIndex];
    
    let html = `
        <h3>Question ${currentIndex + 1} of ${questions.length}</h3>
        <p style="font-size:18px; margin:20px 0;">${q.question_text}</p>
        
        <div style="margin:20px 0;">
            <label class="option-label">
                <input type="radio" name="answer" value="A" ${userAnswers[currentIndex] === 'A' ? 'checked' : ''}>
                A. ${q.option_a}
            </label>
            <label class="option-label">
                <input type="radio" name="answer" value="B" ${userAnswers[currentIndex] === 'B' ? 'checked' : ''}>
                B. ${q.option_b}
            </label>
            <label class="option-label">
                <input type="radio" name="answer" value="C" ${userAnswers[currentIndex] === 'C' ? 'checked' : ''}>
                C. ${q.option_c}
            </label>
            <label class="option-label">
                <input type="radio" name="answer" value="D" ${userAnswers[currentIndex] === 'D' ? 'checked' : ''}>
                D. ${q.option_d}
            </label>
        </div>
    `;

    document.getElementById('question-area').innerHTML = html;

    document.getElementById('btn-prev').disabled = (currentIndex === 0);
    document.getElementById('btn-next').disabled = (currentIndex === questions.length - 1);
}

// Save selected answer
document.addEventListener('change', function(e) {
    if (e.target.name === 'answer') {
        userAnswers[currentIndex] = e.target.value;
    }
});

function nextQuestion() {
    if (currentIndex < questions.length - 1) {
        currentIndex++;
        loadQuestion();
    }
}

function prevQuestion() {
    if (currentIndex > 0) {
        currentIndex--;
        loadQuestion();
    }
}

function submitQuiz(auto = false) {
    if (!auto && !confirm("Are you sure you want to submit the quiz?")) {
        return;
    }

    const timeTaken = totalTime - (Math.floor(Date.now() / 1000) - <?= $_SESSION['current_quiz']['start_time'] ?>);

    const formData = new FormData();
    formData.append('category_id', <?= $category_id ?>);
    formData.append('answers', JSON.stringify(userAnswers));
    formData.append('time_taken', timeTaken);

    fetch('submit-quiz.php', {
        method: 'POST',
        body: formData
    })
    .then(() => {
        window.location.href = `result.php?category_id=<?= $category_id ?>`;
    })
    .catch(() => {
        alert("Error submitting quiz. Please try again.");
    });
}

// Initialize
loadQuestion();
startCountdown();
</script>

<style>
.option-label {
    display: block;
    padding: 14px;
    margin: 10px 0;
    background: #f8f9fa;
    border: 2px solid #ddd;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
}

.option-label:hover {
    background: #e9ecef;
    border-color: #007bff;
}

.option-label input[type="radio"] {
    margin-right: 10px;
}
</style>

<?php include '../includes/footer.php'; ?>