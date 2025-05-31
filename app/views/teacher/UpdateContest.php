<?php
echo '<script>const allProblems = ' . json_encode($problems) . ';</script>';
?>

<div class="row my-6">
    <div class="col">
        <h4>Create Contest</h4>
        <form method="post" id="createContestForm">
            <input type="hidden" name="selectedProblems[]" id="selectedProblemsInput">
            <div class="accordion" id="collapsibleSection">
                <!-- First Section: Contest Details -->
                <div class="card accordion-item active">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDeliveryAddress">
                            Contest Details
                        </button>
                    </h2>
                    <div id="collapseDeliveryAddress" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            <div class="mb-4">
                                <label class="form-label">Contest Name</label>
                                <input type="text" name="contest-name" class="form-control" placeholder="SLSU PROGRAMMING CONTEST">
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Contest Type</label><br>
                                <div class="form-check form-check-inline">
                                    <input name="contest-type" class="form-check-input" type="radio" value="solo" id="contestType-solo" checked>
                                    <label class="form-check-label" for="contestType-solo">Solo-Based</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input name="contest-type" class="form-check-input" type="radio" value="team" id="contestType-team">
                                    <label class="form-check-label" for="contestType-team">Team-Based</label>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Start Time</label>
                                    <div class="input-group">
                                        <input class="form-control" type="datetime-local" name="start_time">
                                        <span class="input-group-text"><i class="fas fa-arrow-alt-circle-right"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">End Time</label>
                                    <div class="input-group">
                                        <input class="form-control" type="datetime-local" name="end_time">
                                        <span class="input-group-text"><i class="fas fa-arrow-alt-circle-left"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Second Section: Selected Problems -->
                <div class="card accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSelectedProblems">
                            Selected Problems
                        </button>
                    </h2>
                    <div id="collapseSelectedProblems" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Problem</th>
                                            <th>Score</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="selectedProblems"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Third Section: Available Problems -->
                <div class="card accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAvailableProblems">
                            Available Problems
                        </button>
                    </h2>
                    <div id="collapseAvailableProblems" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div class="input-group w-50">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Search problems...">
                                    <select id="difficultyFilter" class="form-select">
                                        <option value="">All</option>
                                        <option value="easy">Easy</option>
                                        <option value="medium">Medium</option>
                                        <option value="hard">Hard</option>
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Problem</th>
                                            <th>Difficulty</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="availableProblems"></tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    Page <span id="currentPage">1</span> of <span id="totalPages">1</span>
                                </div>
                                <div>
                                    <button id="prevPage" class="btn btn-sm btn-secondary me-2">Previous</button>
                                    <button id="nextPage" class="btn btn-sm btn-secondary">Next</button>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit" id="submitButton" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
    let filteredProblems = [...allProblems];
    let currentPage = 0;
    const problemsPerPage = 6;
    const selectedProblems = [];

    const renderProblems = () => {
        const table = document.getElementById("availableProblems");
        table.innerHTML = "";
        const start = currentPage * problemsPerPage;
        const paginated = filteredProblems.slice(start, start + problemsPerPage);
        paginated.forEach(problem => {
            const row = document.createElement("tr");
            row.innerHTML = `
            <td>${problem.title}</td> <!-- Use 'title' instead of 'name' -->
            <td><span class="badge bg-${getDifficultyColor(problem.difficulty)}">${problem.difficulty}</span></td>
            <td class="text-center">
                <button type="button" class="btn btn-outline-success btn-sm" onclick='addProblem("${problem.id}")'>Add</button> <!-- Use 'id' to identify the problem -->
            </td>
        `;
            table.appendChild(row);
        });
        document.getElementById("currentPage").textContent = currentPage + 1;
        document.getElementById("totalPages").textContent = Math.ceil(filteredProblems.length / problemsPerPage);
    };

    const renderSelectedProblems = () => {
        const table = document.getElementById("selectedProblems");
        table.innerHTML = "";
        selectedProblems.forEach(problem => {
            const row = document.createElement("tr");
            row.innerHTML = `
            <td>${problem.title}</td> <!-- Use 'title' here as well -->
            <td><input class="form-control w-50" type="number" value="100"></td>
            <td class="text-center">
                <button type="button" class="btn btn-outline-danger btn-sm" onclick='removeProblem("${problem.id}")'>Remove</button> <!-- Use 'id' here -->
            </td>
        `;
            table.appendChild(row);
        });
    };

    const getDifficultyColor = diff => diff === "easy" ? "success" : diff === "medium" ? "warning" : "danger";

    const addProblem = id => {
        const index = filteredProblems.findIndex(p => p.id == id); // Use 'id' for identification
        if (index > -1) {
            const problem = filteredProblems.splice(index, 1)[0];
            selectedProblems.push(problem);
            renderProblems();
            renderSelectedProblems();
        }
    };

    const removeProblem = id => {
        const index = selectedProblems.findIndex(p => p.id == id); // Use 'id' for identification
        if (index > -1) {
            const problem = selectedProblems.splice(index, 1)[0];
            filteredProblems.push(problem); // This should push to filteredProblems, not allProblems
            filterProblems();
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

    document.getElementById("submitButton").addEventListener("click", (event) => {
        event.preventDefault();


        const selectedSlugs = selectedProblems.map(problem => problem.id);


        document.getElementById("selectedProblemsInput").value = JSON.stringify(selectedSlugs);

        document.getElementById("createContestForm").submit();
    });

    filterProblems();
</script>