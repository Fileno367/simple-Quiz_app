<?php 
// student/quiz.php
require_once '../config/database.php';
require_once '../includes/functions.php';

if (!isLoggedIn()) {
    redirect('../student/login.php');
}

if (!isset($_GET['category_id'])) {
    redirect('dashboard.php');
}

$category_id = (int)$_GET['category_id'];

// Fetch questions for this category
$stmt = $pdo->prepare("SELECT * FROM questions WHERE category_id = ? ORDER BY RAND() LIMIT 10");
$stmt->execute([$category_id]);
$questions = $stmt->fetchAll();

if (empty($questions)) {
    echo "No questions available in this category yet.";
    exit;
}

// Store questions in session for this attempt
$_SESSION['current_quiz'] = [
    'category_id' => $category_id,
    'questions'   => $questions,
    'current'     => 0,
    'score'       => 0,
    'start_time'  => time()
];
?>
<?php include '../includes/header.php'; ?>

<h2>Quiz in Progress</h2>

<div class="card" id="quiz-container">
    <div id="question-area">
        <!-- Questions will be loaded by JavaScript -->
    </div>
</div>

<script>
// Pure JavaScript Quiz Logic
let questions = <?php echo json_encode($questions); ?>;
let currentIndex = 0;
let score = 0;
let timer;
let timeLeft = 30; // 30 seconds per question

function startTimer() {
    timeLeft = 30;
    document.getElementById('timer').textContent = timeLeft;
    
    timer = setInterval(() => {
        timeLeft--;
        document.getElementById('timer').textContent = timeLeft;
        
        if (timeLeft <= 0) {
            clearInterval(timer);
            nextQuestion();
        }
    }, 1000);
}

function loadQuestion() {
    if (currentIndex >= questions.length) {
        finishQuiz();
        return;
    }
    
    const q = questions[currentIndex];
    let html = `
        <h3>Question ${currentIndex + 1} of ${questions.length}</h3>
        <p style="font-size:18px; margin:20px 0;">${q.question_text}</p>
        
        <div style="margin:20px 0;">
            <button onclick="selectAnswer('A')" style="display:block; width:100%; margin:8px 0; padding:12px; background:#f8f9fa; border:1px solid #ccc; border-radius:5px; text-align:left;">
                A. ${q.option_a}
            </button>
            <button onclick="selectAnswer('B')" style="display:block; width:100%; margin:8px 0; padding:12px; background:#f8f9fa; border:1px solid #ccc; border-radius:5px; text-align:left;">
                B. ${q.option_b}
            </button>
            <button onclick="selectAnswer('C')" style="display:block; width:100%; margin:8px 0; padding:12px; background:#f8f9fa; border:1px solid #ccc; border-radius:5px; text-align:left;">
                C. ${q.option_c}
            </button>
            <button onclick="selectAnswer('D')" style="display:block; width:100%; margin:8px 0; padding:12px; background:#f8f9fa; border:1px solid #ccc; border-radius:5px; text-align:left;">
                D. ${q.option_d}
            </button>
        </div>
        
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <div><strong>Time Left:</strong> <span id="timer" style="color:red; font-weight:bold;">30</span> seconds</div>
            <button onclick="nextQuestion()" class="btn btn-primary">Skip Question</button>
        </div>
    `;
    
    document.getElementById('question-area').innerHTML = html;
    startTimer();
}

function selectAnswer(selected) {
    clearInterval(timer);
    
    const correct = questions[currentIndex].correct_option;
    
    if (selected === correct) {
        score++;
    }
    
    // Show feedback
    setTimeout(() => {
        nextQuestion();
    }, 800);
}

function nextQuestion() {
    currentIndex++;
    loadQuestion();
}

function finishQuiz() {
    const timeTaken = time() - <?php echo $_SESSION['current_quiz']['start_time']; ?>;
    
    // Save result to database
    const formData = new FormData();
    formData.append('category_id', <?php echo $category_id; ?>);
    formData.append('score', score);
    formData.append('total_questions', questions.length);
    formData.append('time_taken', timeTaken);
    
    fetch('submit-quiz.php', {
        method: 'POST',
        body: formData
    }).then(() => {
        window.location.href = 'result.php?score=' + score + '&total=' + questions.length;
    });
}

// Start the quiz
loadQuestion();
</script>

<?php include '../includes/footer.php'; ?>