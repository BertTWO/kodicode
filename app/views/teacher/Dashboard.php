<div class="container-fluid px-4">
    <!-- Welcome Header with Profile -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Welcome back, <?= ($user_profile['lastname'] ?? '') === '' ? ($_SESSION['user']['username'] ?? 'guest') : ($user_profile['firstname'] ?? '') . ' ' . ($user_profile['lastname'] ?? '') ?>!</h2>
            <p class="text-muted">Here's what's happening with your contests today</p>
        </div>
        <div class="dropdown">
            <button class="btn btn-light rounded-circle p-2" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-fill" style="font-size: 1.5rem;"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="/teacher/profile">Profile Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="/logout">Logout</a></li>
            </ul>
        </div>
    </div>

    <!-- Stats Cards with Icons and Animation -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-start border-primary border-4 shadow-sm h-100 hover-scale">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted fw-bold mb-2">Total Contests</h6>
                            <h2 class="mb-0 fw-bold"><?= $stats['total_contests'] ?? 0 ?></h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="bi bi-trophy-fill text-primary" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="/teacher/manage-contests" class="text-decoration-none small">View all contests <i class="bi bi-arrow-right-short"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-start border-success border-4 shadow-sm h-100 hover-scale">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted fw-bold mb-2">Total Problems</h6>
                            <h2 class="mb-0 fw-bold"><?= $stats['total_problems'] ?? 0 ?></h2>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="bi bi-journal-code text-success" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="/teacher/manage-problems" class="text-decoration-none small">Browse problem bank <i class="bi bi-arrow-right-short"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-start border-info border-4 shadow-sm h-100 hover-scale">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted fw-bold mb-2">Total Participants</h6>
                            <h2 class="mb-0 fw-bold"><?= $stats['total_participants'] ?? 0 ?></h2>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="bi bi-people-fill text-info" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="/teacher/participants" class="text-decoration-none small">View participants <i class="bi bi-arrow-right-short"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions with Cards -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light-subtle mb-3 py-3">
            <h5 class="mb-0 fw-bold">Quick Actions</h5>
        </div>
        <div class="card-body pt-0">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="card bg-black-subtle border-0 h-100">
                        <div class="card-body text-center p-4">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                                <i class="bi bi-plus-circle-fill text-primary" style="font-size: 1.5rem;"></i>
                            </div>
                            <h5 class="card-title">Create Contest</h5>
                            <p class="card-text text-muted small">Set up a new coding challenge for your students</p>
                            <a href="/teacher/manage-contests/create" class="btn btn-primary btn-sm stretched-link">Get Started</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-black-subtle border-0 h-100">
                        <div class="card-body  text-center p-4">
                            <div class="bg-warning bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                                <i class="bi bi-gear-fill text-warning" style="font-size: 1.5rem;"></i>
                            </div>
                            <h5 class="card-title">Manage Contests</h5>
                            <p class="card-text text-muted small">Edit, schedule, or monitor existing contests</p>
                            <a href="/teacher/manage-contests" class="btn btn-outline-primary btn-sm stretched-link">Manage</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-black-subtle border-0 h-100">
                        <div class="card-body text-center p-4">
                            <div class=" bg-dark bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                                <i class="bi bi-journal-bookmark-fill text-dark" style="font-size: 1.5rem;"></i>
                            </div>
                            <h5 class="card-title">Problem Bank</h5>
                            <p class="card-text text-muted small">Access your library of coding problems</p>
                            <a href="/teacher/manage-problems" class="btn btn-outline-dark btn-sm stretched-link">Browse</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-scale {
        transition: transform 0.2s ease;
    }
    .hover-scale:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .border-4 {
        border-width: 4px !important;
    }
</style>