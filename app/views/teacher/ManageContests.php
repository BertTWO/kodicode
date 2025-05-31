<?php
?>

<script>
    const contests = <?php echo json_encode($data); ?>;
</script>

<h4 class="mb-4">Contests You Created</h4>
<div class="row">
    <?php foreach ($myContest as $contest): ?>
        <div class="col-xl-4 col-md-6 col-12 mb-4">
            <div class="card contest-card h-100"
                data-start="<?php echo $contest['start_time']; ?>"
                data-end="<?php echo $contest['end_time']; ?>"
                style="border-radius: 16px; border-left: 4px solid #7367F0; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">

                <div class="card-body position-relative">
                    <!-- Status Label -->
                    <span class="badge status-label position-absolute top-0 end-0 m-3"
                        style="padding: 6px 12px; font-size: 0.75rem; font-weight: 500;">
                    </span>

                    <!-- Contest Title -->
                    <h5 class="fw-bold mb-3 mt-4 text-primary"><?php echo htmlspecialchars($contest['name']); ?></h5>


                    <!-- Progress Bar with Time Info -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between small text-muted mb-1">
                            <span>Start: <?php echo date('M j, g:i A', strtotime($contest['start_time'])); ?></span>
                            <span>End: <?php echo date('M j, g:i A', strtotime($contest['end_time'])); ?></span>
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

                    <!-- Action Buttons -->
                    <div class="d-flex flex-wrap gap-2 mt-3">
                        <form action="manage-contests/update/<?= htmlspecialchars($contest['id']) ?>" method="get" class="d-inline" onsubmit="return confirm('Are you sure you want to update this contest?');">
                            <button type="button" class="btn btn-sm btn-outline-primary confirm-update rounded-pill px-3 confirm-delete">
                                <i class="bi bi-trash me-1"></i> Edit
                            </button>
                        </form>
                        <form action="manage-contests/participants/<?= htmlspecialchars($contest['id']) ?>">
                            <button
                                class="btn btn-sm btn-outline-warning rounded-pill px-3">
                                <i class="bi bi-people me-1"></i> Participants
                            </button>
                        </form>
                        <form action="manage-contests/delete/<?= htmlspecialchars($contest['id']) ?>" method="post" class="d-inline">
                            <button type="button" class="btn btn-sm btn-outline-danger confirm-delete rounded-pill px-3">
                                <i class="bi bi-trash me-1"></i> Delete
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Create New Contest Button -->
    <div class="col-xl-4 col-md-6 col-12 mb-4">
        <div class="card h-100" style="border-radius: 16px; border: 2px dashed #A8AAAE">
            <div class="card-body d-flex flex-column justify-content-center align-items-center text-center p-4">
                <div class="mb-3" style="width: 48px; height: 48px; background-color: #7367F0; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-plus-lg text-white" style="font-size: 1.5rem;"></i>
                </div>
                <h5 class="mb-1">Create New Contest</h5>
                <p class="text-muted small mb-3">Set up a new coding challenge</p>
                <button id="btnCreateContest" class="btn btn-primary rounded-pill px-4">
                    Get Started
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Divider -->
<div class="text-center mb-4">
    <hr class="my-4">
</div>

<!-- Running Contest Card Example -->
<h4 class="mb-3">Other Active Contests</h4>
<div class="row gap-2">
    <?php foreach ($allContest as $contest): ?>
        <div class="col-xl-4 col-md-6 col-12 mb-4">
            <div class="card contest-card h-100"
                data-start="<?php echo $contest['start_time']; ?>"
                data-end="<?php echo $contest['end_time']; ?>"
                style="border-radius: 16px; border-left: 4px solid #7367F0; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">

                <div class="card-body position-relative">
                    <!-- Status Label -->
                    <span class="badge status-label position-absolute top-0 end-0 m-3"
                        style="padding: 6px 12px; font-size: 0.75rem; font-weight: 500;">
                    </span>

                    <!-- Contest Title -->
                    <h5 class="fw-bold mb-3 mt-4 text-primary"><?php echo htmlspecialchars($contest['name']); ?></h5>

                    <!-- Progress Bar with Time Info -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between small text-muted mb-1">
                            <span>Start: <?php echo date('M j, g:i A', strtotime($contest['start_time'])); ?></span>
                            <span>End: <?php echo date('M j, g:i A', strtotime($contest['end_time'])); ?></span>
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
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<script src="/assets/myjs/contest_timer.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const btnCreateContest = document.getElementById('btnCreateContest');
        if (btnCreateContest) {
            btnCreateContest.addEventListener('click', function() {
                window.location.href = 'manage-contests/create';
            });
        }

    });

    document.addEventListener("DOMContentLoaded", function() {
        const deleteButtons = document.querySelectorAll('.confirm-delete');
        const updateButtons = document.querySelectorAll('.confirm-update');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    customClass: {
                        confirmButton: 'btn btn-primary me-1',
                        cancelButton: 'btn btn-label-secondary'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        updateButtons.forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');
                Swal.fire({
                    title: 'Update contest?',
                    text: "Do you want to proceed with updating this contest?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Yes, update it!',
                    customClass: {
                        confirmButton: 'btn btn-primary me-1',
                        cancelButton: 'btn btn-label-secondary'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>