<?php

$joined_contest_ids = array_column($has_joined, 'contest_id');
foreach ($contests as &$contest) {
    $contest['has_joined'] = in_array($contest['id'], $joined_contest_ids);
}

$joinedCounter = 0;
$firstProblemMap = [];

foreach ($firstProblem as $entry) {
    $cid = $entry['contest_id'];
    if (!isset($firstProblemMap[$cid])) {
        $firstProblemMap[$cid] = $entry['problem_id'];
    }
}

unset($contest);
?>

<div class="row">
    <!-- Contest List -->
    <?php foreach ($contests as $index => $contest): ?>
        <div class="col-xl-4 col-md-6 col-12 mb-4">
            <div class="card contest-card h-100"
                data-start="<?= $contest['start_time']; ?>"
                data-end="<?= $contest['end_time']; ?>"
                data-contest-id="<?= $contest['id']; ?>"
                style="border-radius: 16px; border-left: 4px solid #7367F0; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">

                <div class="card-body position-relative">
                    <!-- Status Label -->
                    <span class="badge status-label position-absolute top-0 end-0 m-3"
                        style="padding: 6px 12px; font-size: 0.75rem; font-weight: 500;">
                    </span>

                    <!-- Contest Title -->
                    <h5 class="fw-bold mb-3 mt-4 text-primary"><?= htmlspecialchars($contest['name']); ?></h5>

                    <!-- Contest Info -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between small text-muted mb-1">
                            <span>Start: <?= date('M j, g:i A', strtotime($contest['start_time'])); ?></span>
                            <span>End: <?= date('M j, g:i A', strtotime($contest['end_time'])); ?></span>
                        </div>
                        <div class="progress" style="height: 6px; border-radius: 3px;">
                            <div class="progress-bar bg-primary progress-fill"
                                role="progressbar"
                                style="width: 0%;"
                                aria-valuenow="0"
                                aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                    </div>

                    <!-- Countdown Timer -->
                    <div class="countdown-timer mb-4">
                        <h6 class="small text-muted mb-3">TIME REMAINING</h6>
                        <div class="d-flex justify-content-between text-center">
                            <div class="px-2">
                                <div class="fw-bold fs-4 days text-primary">00</div>
                                <div class="small text-muted">Days</div>
                            </div>
                            <div class="px-2">
                                <div class="fw-bold fs-4 hours text-primary">00</div>
                                <div class="small text-muted">Hours</div>
                            </div>
                            <div class="px-2">
                                <div class="fw-bold fs-4 minutes text-primary">00</div>
                                <div class="small text-muted">Minutes</div>
                            </div>
                            <div class="px-2">
                                <div class="fw-bold fs-4 seconds text-primary">00</div>
                                <div class="small text-muted">Seconds</div>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Action Button -->
                    <div class="contest-action">
                        <?php
                        date_default_timezone_set('Asia/Manila');
                        $current_time = new DateTime();
                        $start_time = new DateTime($contest['start_time']);
                        $end_time = new DateTime($contest['end_time']);

                        $is_running = ($current_time >= $start_time && $current_time <= $end_time);
                        $contestEnded = $current_time > $end_time;
                        ?>

                        <?php if ($contest['has_joined']): ?>
                            <?php
                            $status = $has_joined[$joinedCounter]['status'];
                            ?>

                            <?php if ($status === 'pending'): ?>
                                <button class="btn btn-warning w-100 rounded-pill" disabled>
                                    <i class="bi bi-hourglass-split me-1"></i> Pending
                                </button>

                            <?php elseif ($status === 'accepted'): ?>
                                <?php if ($contestEnded): ?>
                                    <form action="/contest/<?= $contest['id'] ?>/finished" method="post">
                                        <button type="submit" class="btn btn-outline-success w-100 rounded-pill">
                                            <i class="bi bi-bar-chart me-1"></i> View Contest Result
                                        </button>
                                    </form>
                                    <?php elseif ($current_time < $start_time): ?>
                                        <form action="quit/<?= $contest['id']; ?>" method="post">
                                            <button type="submit" class="btn btn-danger w-100 rounded-pill quit-contest-btn"
                                                data-contest-id="<?= $contest['id']; ?>">
                                                <i class="bi bi-door-closed me-1"></i> Quit Contest
                                            </button>
                                        </form>

                                    <?php elseif ($is_running): ?>
                                        <?php if (isset($firstProblemMap[$contest['id']])): ?>
                                            <a href="/contest/<?= $contest['id'] ?>/<?= $firstProblemMap[$contest['id']] ?>" class="btn btn-success w-100 rounded-pill">
                                                <i class="bi bi-joystick me-1"></i> Enter Contest
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-warning w-100 rounded-pill" disabled>
                                                <i class="bi bi-exclamation-triangle me-1"></i> No Problems Yet
                                            </button>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                <?php else: ?>
                                    <button class="btn btn-secondary w-100 rounded-pill" disabled>
                                        <i class="bi bi-x-circle me-1"></i> Join Rejected
                                    </button>
                                <?php endif; ?>

                                <?php $joinedCounter++; ?>

                            <?php else: ?>
                                <?php if ($current_time < $start_time): ?>
                                    <button class="btn btn-primary w-100 rounded-pill join-contest-btn"
                                        data-contest-id="<?= $contest['id']; ?>"
                                        data-is-team-based="<?= $contest['is_team_based'] ? 'true' : 'false'; ?>">
                                        <i class="bi bi-door-open me-1"></i> Join Contest
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-secondary w-100 rounded-pill" disabled>
                                        <i class="bi bi-lock me-1"></i> Contest Ended
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>
                    </div>


                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Join Contest Modal -->
<div class="modal fade" id="joinContestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header bg-primary text-white" style="border-radius: 16px 16px 0 0;">
                <h5 class="modal-title">Join Contest</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form with POST method and action -->
                <form id="joinContestForm" method="POST" action="/your-join-endpoint.php">
                    <input type="hidden" name="contest_id" id="contestId">
                    <input type="hidden" name="participation_type" id="participationType" value="solo">

                    <!-- Team Options -->
                    <div id="teamOptions" style="display: none;">
                        <div class="mb-3">
                            <div class="d-flex gap-3 mb-3">
                                <!-- Join/Create Team Radio Buttons -->
                                <div class="form-check w-100">
                                    <input class="form-check-input" type="radio" name="team_action" id="joinTeam" value="join" checked>
                                    <label class="form-check-label card p-3 w-100" for="joinTeam" style="cursor: pointer;">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-box-arrow-in-right fs-3 text-info me-3"></i>
                                            <div>
                                                <h6 class="mb-1">Join Existing Team</h6>
                                                <small class="text-muted">Enter team password to join</small>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="form-check w-100">
                                    <input class="form-check-input" type="radio" name="team_action" id="createTeam" value="create">
                                    <label class="form-check-label card p-3 w-100" for="createTeam" style="cursor: pointer;">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-plus-circle-fill fs-3 text-success me-3"></i>
                                            <div>
                                                <h6 class="mb-1">Create New Team</h6>
                                                <small class="text-muted">Start your own team</small>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Join Team Form -->
                            <div id="joinTeamForm">
                                <div class="mb-3">
                                    <label for="teamPassword" class="form-label">Team Password</label>
                                    <input type="password" class="form-control" name="team_password" placeholder="Enter team password" required>
                                </div>
                            </div>

                            <!-- Create Team Form -->
                            <div id="createTeamForm" style="display: none;">
                                <div class="mb-3">
                                    <label for="teamName" class="form-label">Team Name</label>
                                    <input type="text" class="form-control" name="team_name" placeholder="Enter team name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="newTeamPassword" class="form-label">Team Password</label>
                                    <input type="password" class="form-control" name="new_team_password" placeholder="Create team password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="confirmTeamPassword" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="confirm_team_password" placeholder="Confirm team password" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary rounded-pill py-2">
                            <i class="bi bi-check-circle me-1"></i> Confirm Participation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="/assets/myjs/contest_timer.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById('joinContestForm');
        const participationType = document.getElementById('participationType');
        const teamOptions = document.getElementById('teamOptions');
        const joinTeamForm = document.getElementById('joinTeamForm');
        const createTeamForm = document.getElementById('createTeamForm');

        // Toggle between Join Team and Create Team forms
        document.querySelectorAll('input[name="team_action"]').forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'join') {
                    joinTeamForm.style.display = 'block';
                    createTeamForm.style.display = 'none';

                    // Enable join inputs
                    joinTeamForm.querySelectorAll('input').forEach(el => el.disabled = false);
                    // Disable create inputs
                    createTeamForm.querySelectorAll('input').forEach(el => el.disabled = true);
                } else if (this.value === 'create') {
                    joinTeamForm.style.display = 'none';
                    createTeamForm.style.display = 'block';

                    // Disable join inputs
                    joinTeamForm.querySelectorAll('input').forEach(el => el.disabled = true);
                    // Enable create inputs
                    createTeamForm.querySelectorAll('input').forEach(el => el.disabled = false);
                }
            });

        });

        // Join Contest Button Click
        document.querySelectorAll('.join-contest-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const contestId = this.getAttribute('data-contest-id');
                const isTeamBased = this.getAttribute('data-is-team-based') === 'true';

                document.getElementById('contestId').value = contestId;

                if (isTeamBased) {
                    participationType.value = 'team';
                    form.action = `team-join/${contestId}`; // Ensure this is a valid endpoint
                    teamOptions.style.display = 'block';

                    const modal = new bootstrap.Modal(document.getElementById('joinContestModal'));
                    modal.show();
                } else {
                    participationType.value = 'solo';
                    form.action = `solo-join/${contestId}`; // Ensure this is a valid endpoint

                    Swal.fire({
                        title: 'Join Solo Contest?',
                        text: 'Are you sure you want to join this contest solo?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, join',
                        cancelButtonText: 'Cancel',
                        customClass: {
                            confirmButton: 'btn btn-primary me-2',
                            cancelButton: 'btn btn-label-secondary'
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Submit the form if confirmed
                        }
                    });
                }
            });
        });

        // Form Submission Handling
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default submission (we'll handle it manually)

            if (participationType.value === 'team') {
                // Validate team form (optional)
                const teamAction = document.querySelector('input[name="team_action"]:checked').value;

                if (teamAction === 'join') {
                    const teamPassword = document.querySelector('input[name="team_password"]').value;
                    if (!teamPassword) {
                        Swal.fire('Error', 'Please enter a team password.', 'error');
                        return;
                    }
                } else if (teamAction === 'create') {
                    const teamName = document.querySelector('input[name="team_name"]').value;
                    const newPassword = document.querySelector('input[name="new_team_password"]').value;
                    const confirmPassword = document.querySelector('input[name="confirm_team_password"]').value;

                    if (!teamName || !newPassword || !confirmPassword) {
                        Swal.fire('Error', 'Please fill all team creation fields.', 'error');
                        return;
                    }

                    if (newPassword !== confirmPassword) {
                        Swal.fire('Error', 'Passwords do not match.', 'error');
                        return;
                    }
                }

                Swal.fire({
                    title: 'Join Team Contest?',
                    text: 'Are you sure you want to proceed?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, join',
                    cancelButtonText: 'Cancel',
                    customClass: {
                        confirmButton: 'btn btn-primary me-2',
                        cancelButton: 'btn btn-label-secondary'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit the form
                    }
                });
            } else {
                form.submit(); // Submit solo form directly
            }
        });
    });
</script>