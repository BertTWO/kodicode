<?php
$isUpdating = isset($contest);
echo '<script>const allProblems = ' . json_encode($isUpdating ? $allProblems : $problems) . ';</script>';

$actionUrl = $isUpdating
    ? "/teacher/manage-contests/update/" . $contest[0]['id'] . ""
    : "/teacher/manage-contests/create";
?>

<div class="row justify-content-center my-4">
    <div class="col-lg-10">
        <div class="card shadow-sm" style="border-radius: 16px; border-left: 4px solid #7367F0;">
            <div class="card-header py-3">
                <h4 class="mb-0">
                    <i class="bi bi-trophy-fill me-2"></i>
                    <?= $isUpdating ? 'Update Contest' : 'Create New Contest' ?>
                </h4>
            </div>

            <div class="card-body">
                <form method="post" action="<?php echo"".$actionUrl; ?>" id="createContestForm" class="needs-validation" novalidate>
                    <input type="hidden" name="selectedProblems[]" id="selectedProblemsInput">

                    <!-- Accordion Sections -->
                    <div class="accordion" id="contestFormAccordion">
                        <!-- Section 1: Contest Details -->
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button d-flex bg-light justify-content-between align-items-center rounded-3 py-3"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseContestDetails"
                                    aria-expanded="true">
                                    <span class="fw-semibold">
                                        <i class="bi bi-info-circle-fill me-2 text-primary"></i>
                                        Contest Details
                                    </span>
                                    <i class="bi bi-chevron-down transition-transform"></i>
                                </button>
                            </h2>
                            <div id="collapseContestDetails" class="accordion-collapse collapse show" data-bs-parent="#contestFormAccordion">
                                <div class="accordion-body pt-4">
                                    <div class="row g-3">
                                        <!-- Contest Name -->
                                        <div class="col-md-12">
                                            <label for="contestName" class="form-label fw-semibold">Contest Name</label>
                                            <input type="text"
                                                id="contestName"
                                                value="<?php echo ($isUpdating ? htmlspecialchars($contest[0]['name']) : '') ?>"
                                                name="contest-name"
                                                class="form-control form-control-lg"
                                                placeholder="e.g. SLSU Annual Programming Contest"
                                                required>
                                            <div class="invalid-feedback">Please provide a contest name.</div>
                                        </div>

                                        <!-- Contest Type -->
                                        <div class="col-md-12">
                                            <label class="form-label fw-semibold">Contest Type</label>
                                            <div class="d-flex gap-4">
                                                <div class="form-check">
                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="contest-type"
                                                        id="contestType-solo"
                                                        value="solo"
                                                        <?php echo (!$isUpdating || $contest[0]['is_team_based'] == '0' ? 'checked' : ''); ?>
                                                        required>
                                                    <label class="form-check-label d-flex align-items-center" for="contestType-solo">
                                                        <span class="badge bg-primary rounded-pill me-2"><i class="bi bi-person-fill"></i></span>
                                                        Solo-Based
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="contest-type"
                                                        id="contestType-team"
                                                        value="team"
                                                        <?php echo ($isUpdating && $contest[0]['is_team_based'] == '1' ? 'checked' : ''); ?>>
                                                    <label class="form-check-label d-flex align-items-center" for="contestType-team">
                                                        <span class="badge bg-warning rounded-pill me-2"><i class="bi bi-people-fill"></i></span>
                                                        Team-Based
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Date & Time -->
                                        <div class="col-md-6">
                                            <label for="startTime" class="form-label fw-semibold">Start Time</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-primary text-white"><i class="bi bi-calendar-event"></i></span>
                                                <input class="form-control"
                                                    id="startTime"
                                                    type="datetime-local"
                                                    value="<?php echo ($isUpdating ? htmlspecialchars($contest[0]['start_time']) : '') ?>"
                                                    name="start_time"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="endTime" class="form-label fw-semibold">End Time</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-primary text-white"><i class="bi bi-calendar-event"></i></span>
                                                <input class="form-control"
                                                    id="endTime"
                                                    type="datetime-local"
                                                    value="<?php echo ($isUpdating ? htmlspecialchars($contest[0]['end_time']) : '') ?>"
                                                    name="end_time"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Selected Problems -->
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button bg-light d-flex justify-content-between align-items-center rounded-3 py-3 collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseSelectedProblems">
                                    <span class="fw-semibold">
                                        <i class="bi bi-list-check me-2 text-primary"></i>
                                        Selected Problems
                                        <span id="selectedCountBadge" class="badge bg-primary ms-2">0</span>
                                    </span>
                                    <i class="bi bi-chevron-down transition-transform"></i>
                                </button>
                            </h2>
                            <div id="collapseSelectedProblems" class="accordion-collapse collapse" data-bs-parent="#contestFormAccordion">
                                <div class="accordion-body pt-4">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="45%">Problem</th>
                                                    <th width="25%">Difficulty</th>
                                                    <th width="20%">Score</th>
                                                    <th width="10%" class="text-end">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="selectedProblems">
                                                <?php if ($isUpdating) {
                                                    foreach ($problems as $problem): ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($problem[0]['title']) ?></td>
                                                            <td>
                                                                <span class="badge bg-<?=
                                                                                        $problem[0]['difficulty'] === 'easy' ? 'success' : ($problem[0]['difficulty'] === 'medium' ? 'warning' : 'danger')
                                                                                        ?>">
                                                                    <?= ucfirst($problem[0]['difficulty']) ?>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <input class="form-control"
                                                                    type="number"
                                                                    value="<?= $isUpdating ? htmlspecialchars($contest_problems[0]['total_score']) : '100' ?>"
                                                                    min="1"
                                                                    required>
                                                            </td>
                                                            <td class="text-end">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                                                    onclick="removeProblem('<?= htmlspecialchars($problem[0]['id']) ?>')">
                                                                    <i class="bi bi-trash me-1"></i> Remove
                                                                </button>
                                                            </td>
                                                        </tr>
                                                <?php endforeach;
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Available Problems -->
                        <div class="accordion-item border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button bg-light d-flex justify-content-between align-items-center rounded-3 py-3 collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseAvailableProblems">
                                    <span class="fw-semibold">
                                        <i class="bi bi-search me-2 text-primary"></i>
                                        Available Problems
                                    </span>
                                    <i class="bi bi-chevron-down transition-transform"></i>
                                </button>
                            </h2>
                            <div id="collapseAvailableProblems" class="accordion-collapse collapse" data-bs-parent="#contestFormAccordion">
                                <div class="accordion-body pt-4">
                                    <!-- Search and Filter -->
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                                                <input type="text"
                                                    id="searchInput"
                                                    class="form-control"
                                                    placeholder="Search problems by title...">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <select id="difficultyFilter" class="form-select">
                                                <option value="">All Difficulty Levels</option>
                                                <option value="easy">Easy</option>
                                                <option value="medium">Medium</option>
                                                <option value="hard">Hard</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Problems Table -->
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="60%">Problem</th>
                                                    <th width="30%">Difficulty</th>
                                                    <th width="10%" class="text-end">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="availableProblems"></tbody>
                                        </table>
                                    </div>

                                    <!-- Pagination -->
                                    <div class="d-flex justify-content-between align-items-center mt-4">
                                        <div class="text-muted small">
                                            Showing <span id="startItem">1</span> to <span id="endItem">6</span> of <span id="totalItems">0</span> problems
                                        </div>
                                        <div>
                                            <button id="prevPage" class="btn btn-sm btn-outline-primary me-2">
                                                <i class="bi bi-chevron-left"></i> Previous
                                            </button>
                                            <button id="nextPage" class="btn btn-sm btn-outline-primary">
                                                Next <i class="bi bi-chevron-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-end gap-3 mt-5 pt-4 border-top">
                        <button type="reset" class="btn text-center btn-lg btn-outline-secondary px-4 rounded-pill">
                            <i class="bi bi-x-circle me-2"></i> Cancel
                        </button>
                        <button type="submit" id="submitButton" class="btn text-center btn-lg btn-primary px-4 rounded-pill">
                            <i class="bi bi-check-circle me-2"></i>
                            <?= $isUpdating ? 'Update Contest' : 'Create Contest' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Enhanced JavaScript with better UI feedback
    let filteredProblems = [...allProblems];
    let currentPage = 0;
    const problemsPerPage = 6;
    const selectedProblems = <?= $isUpdating ? json_encode(array_map(function ($p) {
                                    return $p[0];
                                }, $problems)) : '[]' ?>;

    // Update selected count badge
    const updateSelectedCount = () => {
        document.getElementById('selectedCountBadge').textContent = selectedProblems.length;
    };

    const getDifficultyColor = diff => diff === "easy" ? "success" : diff === "medium" ? "warning" : "danger";

    const renderProblems = () => {
        const table = document.getElementById("availableProblems");
        table.innerHTML = "";

        const start = currentPage * problemsPerPage;
        const paginated = filteredProblems.slice(start, start + problemsPerPage);

        // Update pagination info
        document.getElementById("startItem").textContent = start + 1;
        document.getElementById("endItem").textContent = Math.min(start + problemsPerPage, filteredProblems.length);
        document.getElementById("totalItems").textContent = filteredProblems.length;

        if (paginated.length === 0) {
            table.innerHTML = `
                <tr>
                    <td colspan="3" class="text-center py-4 text-muted">
                        <i class="bi bi-exclamation-circle fs-4"></i>
                        <p class="mt-2">No problems found matching your criteria</p>
                    </td>
                </tr>
            `;
            return;
        }

        paginated.forEach(problem => {
            const isSelected = selectedProblems.some(p => p.id === problem.id);
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${problem.title}</td>
                <td>
                    <span class="badge bg-${getDifficultyColor(problem.difficulty)}">
                        ${problem.difficulty.charAt(0).toUpperCase() + problem.difficulty.slice(1)}
                    </span>
                </td>
                <td class="text-end">
                    <button type="button" 
                            class="btn btn-sm ${isSelected ? 'btn-success disabled' : 'btn-outline-success'} rounded-pill px-3"
                            onclick="addProblem('${problem.id}')"
                            ${isSelected ? 'disabled' : ''}>
                        <i class="bi bi-plus me-1"></i>
                        ${isSelected ? 'Added' : 'Add'}
                    </button>
                </td>
            `;
            table.appendChild(row);
        });
    };

    const renderSelectedProblems = () => {
        const table = document.getElementById("selectedProblems");
        table.innerHTML = "";

        if (selectedProblems.length === 0) {
            table.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center py-4 text-muted">
                        <i class="bi bi-info-circle fs-4"></i>
                        <p class="mt-2">No problems selected yet</p>
                    </td>
                </tr>
            `;
            return;
        }

        selectedProblems.forEach(problem => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${problem.title}</td>
                <td>
                    <span class="badge bg-${getDifficultyColor(problem.difficulty)}">
                        ${problem.difficulty.charAt(0).toUpperCase() + problem.difficulty.slice(1)}
                    </span>
                </td>
                <td>
                    <input class="form-control" 
                           type="number" 
                           value="100" 
                           min="1"
                           required>
                </td>
                <td class="text-end">
                    <button type="button" 
                            class="btn btn-sm btn-outline-danger rounded-pill px-3"
                            onclick="removeProblem('${problem.id}')">
                        <i class="bi bi-trash me-1"></i> Remove
                    </button>
                </td>
            `;
            table.appendChild(row);
        });

        updateSelectedCount();
    };

    const addProblem = id => {
        const problem = filteredProblems.find(p => p.id == id);
        if (problem && !selectedProblems.some(p => p.id == id)) {
            selectedProblems.push(problem);
            renderProblems();
            renderSelectedProblems();

            // Show toast notification
            const toast = new bootstrap.Toast(document.getElementById('addedToast'));
            toast.show();
        }
    };

    const removeProblem = id => {
        const index = selectedProblems.findIndex(p => p.id == id);
        if (index > -1) {
            selectedProblems.splice(index, 1);
            renderProblems();
            renderSelectedProblems();
        }
    };

    const filterProblems = () => {
        const keyword = document.getElementById("searchInput").value.toLowerCase();
        const difficulty = document.getElementById("difficultyFilter").value;

        filteredProblems = allProblems.filter(p =>
            p.title.toLowerCase().includes(keyword) &&
            (difficulty ? p.difficulty === difficulty : true)
        );

        currentPage = 0;
        renderProblems();
    };

    // Initialize
    document.addEventListener("DOMContentLoaded", () => {
        // Form validation
        const form = document.getElementById('createContestForm');
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');

            // Set selected problems before submit
            const selectedIds = selectedProblems.map(p => p.id);
            document.getElementById("selectedProblemsInput").value = JSON.stringify(selectedIds);
        }, false);

        // Event listeners
        document.getElementById("searchInput").addEventListener("input", filterProblems);
        document.getElementById("difficultyFilter").addEventListener("change", filterProblems);

        document.getElementById("nextPage").addEventListener("click", (event) => {
            event.preventDefault();
            if ((currentPage + 1) * problemsPerPage < filteredProblems.length) {
                currentPage++;
                renderProblems();
            }
        });

        document.getElementById("prevPage").addEventListener("click", (event) => {
            event.preventDefault();
            if (currentPage > 0) {
                currentPage--;
                renderProblems();
            }
        });

        // Initial render
        filterProblems();
        renderSelectedProblems();
    });
</script>

<!-- Toast Notification -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="addedToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-check-circle-fill me-2"></i>
                Problem added to contest
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>