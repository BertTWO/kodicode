<?php
// Your PHP code here
?>

<style>
  :root {
    --slate-900: #0f172a;
    --slate-800: #1e293b;
    --slate-700: #334155;
    --violet-400: #a78bfa;
    --terminal-green: #00ff9d;
    --terminal-text: #e2e8f0;
  }

  /* Confetti Styles */
  .confetti-container {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    pointer-events: none;
    z-index: 1;
  }

  .confetti {
    position: absolute;
    width: 10px;
    height: 10px;
    opacity: 0;
    animation: confetti-fall 3s ease-in forwards;
  }

  @keyframes confetti-fall {
    0% {
      transform: translateY(-100px) rotate(0deg);
      opacity: 1;
    }
    100% {
      transform: translateY(100vh) rotate(360deg);
      opacity: 0;
    }
  }

  /* Base Styles */
  body {
    background-color: var(--slate-900);
    color: var(--terminal-text);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    margin: 0;
    min-height: 100vh;
    display: grid;
    place-items: center;
    padding: 1rem;
  }

  .card {
    background-color: var(--slate-800);
    border-radius: 0.5rem;
    border: 1px solid var(--slate-700);
    padding: 2rem;
    max-width: 480px;
    width: 100%;
    position: relative;
    overflow: hidden;
  }

  .title {
    color: var(--terminal-green);
    font-weight: 600;
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
    text-align: center;
  }

  /* Pending State */
  .pending-container {
    background: rgba(30, 41, 59, 0.5);
    border-radius: 0.5rem;
    padding: 1.5rem;
    margin: 1rem 0;
    text-align: center;
  }

  .pending-icon {
    font-size: 2rem;
    color: var(--violet-400);
    margin-bottom: 1rem;
    animation: pulse 2s infinite;
  }

  .pending-text {
    color: var(--terminal-text);
    margin-bottom: 0.5rem;
  }

  /* Results State */
  .results-container {
    margin: 1rem 0;
  }

  .rank-display {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
  }

  .rank-badge {
    width: 3rem;
    height: 3rem;
    border-radius: 0.5rem;
    background: rgba(0, 255, 157, 0.1);
    border: 1px solid var(--terminal-green);
    display: grid;
    place-items: center;
    font-weight: 600;
    color: var(--terminal-green);
  }

  .rank-label {
    font-size: 1rem;
  }

  .score-box {
    background: rgba(30, 41, 59, 0.7);
    border-radius: 0.5rem;
    padding: 1.5rem;
    text-align: center;
  }

  .score {
    font-size: 2.5rem;
    font-weight: 600;
    margin: 0.5rem 0;
    color: white;
  }

  .btn:hover {
    background: rgba(0, 255, 157, 0.2);
  }

  @keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
  }
</style>

<div class="card mx-auto">
  <?php if ($isFinished): ?>
    <!-- Confetti Container (only shown when finished) -->
    <div class="confetti-container" id="confetti-container"></div>
  <?php endif ?>

  <h1 class="title"><?= $isFinished ? 'Contest Complete' : 'Submission Received' ?></h1>

  <?php if ($isFinished): ?>
    <!-- Results State -->
    <div class="results-container">
      <div class="rank-display">
        <div class="rank-badge"><?= $rank ?></div>
        <div class="rank-label">
          <?= $rank == 1 ? '1st Place' : ($rank == 2 ? '2nd Place' : ($rank == 3 ? '3rd Place' : 'Ranked')) ?>
        </div>
      </div>

      <div class="score-box">
        <div>Your Score</div>
        <div class="score"><?= $averageScore ?>/100</div>
      </div>
    </div>
  <?php else: ?>
    <!-- Pending State -->
    <div class="pending-container">
      <div class="pending-icon">⏳</div>
      <div class="pending-text">Results Pending Review</div>
      <div>Your score will appear here once finished</div>
    </div>
  <?php endif ?>

  <a href="/student/dashboard" class="btn btn-outline-success rounded rounded-4">Continue to Dashboard</a>
</div>

<?php if ($isFinished): ?>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('confetti-container');
    const colors = ['#00ff9d', '#22d3ee', '#a78bfa', '#fbbf24', '#fb7185'];
    
    // Create 50 pieces of confetti
    for (let i = 0; i < 50; i++) {
      const confetti = document.createElement('div');
      confetti.className = 'confetti';
      confetti.style.left = Math.random() * 100 + '%';
      confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
      confetti.style.width = (Math.random() * 8 + 4) + 'px';
      confetti.style.height = (Math.random() * 4 + 4) + 'px';
      confetti.style.animationDelay = (Math.random() * 2) + 's';
      confetti.style.animationDuration = (Math.random() * 2 + 2) + 's';
      container.appendChild(confetti);
    }
    
    // Remove container after animation
    setTimeout(() => {
      container.remove();
    }, 6000);
  });
</script>
<?php endif ?>