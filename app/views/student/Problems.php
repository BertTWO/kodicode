<?php
$solvedIds = array_column($data['solvedProblems'], 'problem_id');
$totalProblems = count($data['problems']);
$totalSolved = count($solvedIds);
$solvedPercent = $totalProblems > 0 ? round(($totalSolved / $totalProblems) * 100) : 0;

$difficultyCounts = ['Easy' => 0, 'Medium' => 0, 'Hard' => 0];
$solvedDifficultyCounts = ['Easy' => 0, 'Medium' => 0, 'Hard' => 0];


foreach ($data['problems'] as $problem) {

  $difficulty = ucfirst(strtolower(trim($problem['difficulty'] ?? '')));

  if (isset($difficultyCounts[$difficulty])) {
    $difficultyCounts[$difficulty]++;
    if (in_array($problem['id'], $solvedIds)) {
      $solvedDifficultyCounts[$difficulty]++;
    }
  }
  
  $unsolvedProblems = array_filter($data['problems'], function ($problem) use ($solvedIds) {
    return !in_array($problem['id'], $solvedIds);
  });
  $randomUnsolved = null;
  if (count($unsolvedProblems) > 0) {
    $randomUnsolved = $unsolvedProblems[array_rand($unsolvedProblems)];
  }
}

?>

<div class="row g-4">
  <!-- Problem List -->
  <div class="col-lg-9">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Your Coding Progress</h5>
      </div>
      <div class="card-body">
        <!-- Search & Refresh -->
        <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
          <input type="text" id="searchInput" class="form-control flex-grow-1 me-2" placeholder="Search problems..." />
          <button class="btn btn-outline-primary" onclick="refreshProblems()">Refresh</button>
        </div>
        <!-- Problem Table -->
        <div class="table-responsive">
          <table class="table table-bordered table-striped text-center align-middle mb-3">
            <thead class="table-light">
              <tr>
                <th>Problem</th>
                <th>Difficulty</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="problemTable">
              <?php foreach ($data['problems'] as $problem): ?>
                <tr>
                  <td>
                    <?= htmlspecialchars($problem['title']) ?>
                    <?php if (in_array($problem['id'], $solvedIds)): ?>
                      <span class="badge bg-success ms-2">Solved</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if ($problem['difficulty'] === 'Easy'): ?>
                      <span class="text-success"><?= htmlspecialchars($problem['difficulty']) ?></span>
                    <?php elseif ($problem['difficulty'] === 'Medium'): ?>
                      <span class="text-warning"><?= htmlspecialchars($problem['difficulty']) ?></span>
                    <?php else: ?>
                      <span class="text-danger"><?= htmlspecialchars($problem['difficulty']) ?></span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <a href="problems/<?= htmlspecialchars($problem['slug']) ?>"
                      class="btn
           <?php if (in_array($problem['id'], $solvedIds)): ?>
             btn-outline-success
           <?php elseif ($problem['difficulty'] === 'Easy'): ?>
             btn-success
           <?php elseif ($problem['difficulty'] === 'Medium'): ?>
             btn-primary
           <?php else: ?>
             btn-warning
           <?php endif; ?>">
                      <?= in_array($problem['id'], $solvedIds) ? 'Review' : 'Solve' ?>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>

            </tbody>
          </table>
        </div>
        <!-- Pagination -->
        <nav>
          <ul class="pagination justify-content-end mb-0">
            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
          </ul>
        </nav>
      </div>
    </div>
  </div>

  <!-- Sidebar Stats -->
  <div class="col-lg-3">
    <div class="card h-100">
      <div class="card-header">
        <h5 class="mb-0">Your Stats</h5>
      </div>
      <div class="card-body text-center">
        <!-- Overall Stats -->
        <div class="mb-3">
          <div class="display-6 fw-bold"><?= $solvedPercent ?>%</div>
          <small class="text-muted">Solved</small>
        </div>
        <!-- Difficulty Breakdown -->
        <ul class="list-group text-start mb-3">
          <?php foreach ($difficultyCounts as $difficulty => $totalCount): ?>
            <li class="list-group-item d-flex justify-content-between">
              <span><?= htmlspecialchars($difficulty) ?></span>
              <span><?= $solvedDifficultyCounts[$difficulty] ?> / <?= $totalCount ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
        <!-- New Challenge Button -->
        <button class="btn btn-primary w-100"
          <?= $randomUnsolved ? 'onclick="location.href=\'problems/' . htmlspecialchars($randomUnsolved['slug']) . '\'"' : 'disabled' ?>>
          New Challenge
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  document.getElementById('searchInput').addEventListener('input', function() {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('#problemTable tr');

    rows.forEach(row => {
      const title = row.querySelector('td:first-child').textContent.toLowerCase();
      if (title.includes(searchValue)) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  });

  function refreshProblems() {
    location.reload();
  }
</script>