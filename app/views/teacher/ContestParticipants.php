<?php

?>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm" style="border-radius: 16px; border-left: 4px solid #7367F0;">
            <div class="card-header text-white py-3" style="border-radius: 16px 16px 0 0 !important;">
                <h5 class="mb-0">
                    <i class="bi bi-people-fill me-2"></i>
                    Contest Participants: <?php echo htmlspecialchars($contest[0]['name']); ?>
                </h5>
            </div>

            <div class="card-body">
                <!-- Time Info -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="text-muted small">
                        <i class="bi bi-calendar me-1"></i>
                        <?php echo date('M j, Y g:i A', strtotime($contest[0]['start_time'])); ?> -
                        <?php echo date('M j, Y g:i A', strtotime($contest[0]['end_time'])); ?>
                    </div>

                    <div class="d-flex gap-2">
                        <div class="input-group" style="width: 250px;">
                            <input type="text" class="form-control" placeholder="Search participants...">
                            <button class="btn btn-outline-primary" type="button">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Participants Table -->
                <div class="table-responsive">
    <table class="table table-hover align-middle" style="min-width: 800px;">
        <thead class="table-dark">
            <tr>
                <th style="width: 80px;">RANK</th>
                <th>PARTICIPANT</th>
                <th style="width: 100px;">TYPE</th>
                <th style="width: 120px;">STATUS</th>
                <th style="width: 100px;">SCORE</th>
                <th style="width: 200px;">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($participants as $participant): ?>
                <tr>
                    <!-- Rank Column -->
                    <td>
                        <?php if ($participant['rank'] == 1): ?>
                            <span class="badge bg-warning text-dark rounded-pill px-3 py-1 d-inline-flex align-items-center">
                                <i class="bi bi-trophy-fill me-1"></i>1st
                            </span>
                        <?php elseif ($participant['rank'] == 2): ?>
                            <span class="badge bg-secondary rounded-pill px-3 py-1 d-inline-flex align-items-center">
                                <i class="bi bi-award-fill me-1"></i>2nd
                            </span>
                        <?php elseif ($participant['rank'] == 3): ?>
                            <span class="badge bg-danger rounded-pill px-3 py-1 d-inline-flex align-items-center">
                                <i class="bi bi-award-fill me-1"></i>3rd
                            </span>
                        <?php else: ?>
                            <span class="badge bg-dark rounded-pill px-3 py-1">
                                #<?= $participant['rank'] ?>
                            </span>
                        <?php endif; ?>
                    </td>
                    
                    <!-- Participant Column -->
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-sm me-3">
                                <span class="avatar-initial rounded-circle bg-label-primary">
                                    <?= strtoupper(substr($participant['name'], 0, 1)) ?>
                                </span>
                            </div>
                            <div>
                                <h6 class="mb-0 text-truncate" style="max-width: 200px;"><?= htmlspecialchars($participant['name']) ?></h6>
                            </div>
                        </div>
                    </td>
                    
                    <!-- Type Column -->
                    <td>
                        <span class="badge bg-<?= $participant['is_team'] ? 'warning' : 'info' ?> rounded-pill">
                            <?= $participant['is_team'] ? 'Team' : 'Individual' ?>
                        </span>
                    </td>
                    
                    <!-- Status Column -->
                    <td>
                        <span class="badge bg-<?= 
                            $participant['status'] === 'accepted' ? 'success' : 
                            ($participant['status'] === 'rejected' ? 'danger' : 'warning')
                        ?> rounded-pill">
                            <?= ucfirst($participant['status']) ?>
                        </span>
                    </td>
                    
                    <!-- Score Column -->
                    <td class="fw-bold">
                        <?= $participant['score'] ?>
                    </td>
                    
                    <!-- Actions Column -->
                    <td>
                        <?php if (trim($participant['status']) === "pending"): ?>
                            <div class="d-flex gap-2">
                                <form action="accept/<?= $participant['user_id'] ?>" method="POST">
                                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">
                                        <i class="bi bi-check-circle me-1"></i> Accept
                                    </button>
                                </form>
                                <form action="reject/<?= $participant['user_id'] ?>" method="POST">
                                    <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3">
                                        <i class="bi bi-x-circle me-1"></i> Reject
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<style>
    /* Ensure table cells don't wrap */
    .table td, .table th {
        white-space: nowrap;
    }
    
    /* Make participant names truncate if too long */
    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        display: inline-block;
        max-width: 100%;
    }
    
    /* Rank badge styling */
    .badge.bg-warning {
        background-color: #ffc107 !important;
    }
    .badge.bg-secondary {
        background-color: #6c757d !important;
    }
    .badge.bg-danger {
        background-color: #dc3545 !important;
    }
</style>