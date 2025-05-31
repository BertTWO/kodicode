<?php
$problemIds = array_column($data['problems'],'id');

?>

<div class="row g-4">
    <!-- Problem List -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header text-white  d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Manage Problems</h5>
            </div>
            <div class="card-body">
                <!-- Search & Refresh -->
                <div class="d-flex justify-content-between mb-3">
                    <div class="d-flex gap-2">
                        <input type="text" id="searchInput" class="form-control" placeholder="Search problems..." />
                        <button class="btn btn-outline-primary" onclick="refreshProblems()">Refresh</button>
                    </div>
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#addNewAddress">
                        Create Problem
                    </button>
                </div>

                <?php if (empty($data['problems'])) { ?>
                    <div class="alert alert-warning" role="alert">You have not created a problem yet!</div>
                <?php
                } else {
                ?>

                    <!-- Problem Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle mb-3">
                            <thead class="table-light">
                                <tr>
                                    <th>Problem</th>
                                    <th>Difficulty</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="problemTable">
                                <?php foreach ($data['problems'] as $problem): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($problem['title']) ?></td>
                                        <td>
                                            <?php if ($problem['difficulty'] === 'Easy'): ?>
                                                <span class="badge bg-success"><?= htmlspecialchars($problem['difficulty']) ?></span>
                                            <?php elseif ($problem['difficulty'] === 'Medium'): ?>
                                                <span class="badge bg-warning"><?= htmlspecialchars($problem['difficulty']) ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-danger"><?= htmlspecialchars($problem['difficulty']) ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="manage-problems/update/<?= htmlspecialchars($problem['slug']) ?>" class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <form action="manage-problems/<?= htmlspecialchars($problem['slug']) ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this problem?');">
                                                <button type="button" class="btn btn-danger btn-sm waves-effect waves-light confirm-delete">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach;  ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
                <!-- Pagination -->
                <nav aria-label="Page navigation">
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
</div>

<div class="row g-4 mt-5">
    <!-- Problem List -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header text-white  d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Problems</h5>
            </div>
            <div class="card-body">
                <!-- Search & Refresh -->
                <div class="d-flex justify-content-between mb-3">
                    <div class="d-flex gap-2">
                        <input type="text" id="allSearchInput" class="form-control" placeholder="Search problems..." />
                        <button class="btn btn-outline-primary" onclick="refreshProblems()">Refresh</button>
                    </div>
                </div>

                <?php if (empty($data['allProblems'])) { ?>
                    <div class="alert alert-warning" role="alert">Theres no Public Problem Yet!</div>
                <?php
                } else {
                ?>

                    <!-- Problem Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle mb-3">
                            <thead class="table-light">
                                <tr>
                                    <th>Problem</th>
                                    <th>Difficulty</th>
                                    <th class="text-center">Creator</th>
                                </tr>
                            </thead>
                            <tbody id="allProblemTable">
                                <?php foreach ($data['allProblems'] as $problem): ?>
                                    <?php if (!in_array($problem['id'],$problemIds)): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($problem['title']) ?></td>
                                            <td>
                                                <?php if ($problem['difficulty'] === 'Easy'): ?>
                                                    <span class="badge bg-success"><?= htmlspecialchars($problem['difficulty']) ?></span>
                                                <?php elseif ($problem['difficulty'] === 'Medium'): ?>
                                                    <span class="badge bg-warning"><?= htmlspecialchars($problem['difficulty']) ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger"><?= htmlspecialchars($problem['difficulty']) ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <span class=""><?= htmlspecialchars($problem['firstname']) . " " . htmlspecialchars($problem['lastname']) ?></span>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach;  ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
                <!-- Pagination -->
                <nav aria-label="Page navigation">
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
</div>
<!-- MODAL CONTENT: Create Problem -->
<div class="modal fade" id="addNewAddress" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="bs-stepper wizard-numbered">
                <div class="bs-stepper-header">
                    <div class="step active" data-target="#account-details">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle">1</span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">UpdateProblem Details</span>
                                <span class="bs-stepper-subtitle">Setup Problem Info</span>
                            </span>
                        </button>
                    </div>
                    <div class="line"></div>
                    <div class="step" data-target="#personal-info">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle">2</span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">More Info</span>
                                <span class="bs-stepper-subtitle">Optional Metadata</span>
                            </span>
                        </button>
                    </div>
                    <div class="line"></div>
                    <div class="step" data-target="#social-links">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle">3</span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Social Links</span>
                                <span class="bs-stepper-subtitle">(Optional)</span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="bs-stepper-content">
                    <form id="createProblemForm" method="post" enctype="multipart/form-data">
                        <!-- Step 1 -->
                        <div id="account-details" class="content active dstepper-block">
                            <h5 class="mt-3 mb-3">Problem Information</h5>

                            <div class="mb-3 row">
                                <label for="problem-title" class="col-sm-3 col-form-label">Problem Title</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="problem-title" name="title" placeholder="e.g. Sum of Numbers">
                                </div>
                            </div>


                            <div class="mb-4 row">
                                <label for="difficulty" class="col-sm-3 col-form-label">Difficulty</label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="difficulty" id="difficulty">
                                        <option value="Easy">Easy</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Hard">Hard</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-4 row">
                                <label for="is_public" class="col-sm-3 col-form-label">Visibility</label>
                                <div class="col-sm-9 d-flex align-items-center">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_public" name="is_public" value="1" checked>
                                        <label class="form-check-label" for="is_public">Public</label>
                                    </div>
                                </div>
                            </div>

                            <h6 class="mb-3 mt-5">Problem Description</h6>
                            <textarea name="description" id="problem-description" class="form-control mb-5" rows="5" placeholder="e.g. Given a list of numbers, return their sum."></textarea>
                            <h6 class="mb-3 mt-5">Example Inputs</h6>
                            <div id="exampleContainer" class="mb-3" style="max-height: 300px; overflow-y: auto;">
                                <div class="card example-pair mb-2 shadow-sm p-3">
                                    <div class="mb-2">
                                        <label class="form-label">Input</label>
                                        <textarea name="example[]" class="form-control" rows="3" style="background-color: #282a36; color: #fff;" placeholder="e.g. 2 4 6"></textarea>
                                    </div>
                                    <button type="button" class="btn btn-outline-danger btn-sm remove-example">
                                        <i class="bi bi-x-circle"></i> Remove Example
                                    </button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-success mb-4 mx-3" id="addExampleBtn">
                                <i class="bi bi-plus-circle"></i> Add Example
                            </button>

                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary btn-next">Next</button>
                            </div>
                        </div>

                        <!-- Put The Test Cases Here the same as the top one -->
                        <div id="personal-info" class="content">
                            <h5 class="mt-3 mb-3">Test Cases (Required)</h5>
                            <div id="accordionCustomIcon" class="accordion mb-3"></div>
                            <button type="button" class="btn btn-outline-success mb-4 mx-3" id="addTestCaseBtn">
                                <i class="bi bi-plus-circle"></i> Add Test Case
                            </button>
                            <button type="button" class="btn btn-outline-danger mb-4 mx-3" id="resetTestCaseBtn">
                                <i class="bi bi-plus-circle"></i> Reset
                            </button>

                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary btn-prev">Previous</button>
                                <button type="button" class="btn btn-primary btn-next">Next</button>
                            </div>
                        </div>


                        <!-- Step 3 -->
                        <div id="social-links" class="content">
                            <div class="row">
                                <!-- Main Content -->
                                <div class="col-12 editor-main d-flex flex-column" id="mainContent" style="transition: all 0.3s; height: 100vh; overflow-y: auto;">
                                    <div class="col-12">
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-success" id="progressBar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                                        <h5 class="mb-0">Code Editor</h5>
                                        <div class="d-flex align-items-center">
                                            <button type="button" onclick="runBatchCode();" id="btnRunBatch" class="btn btn-outline-info waves-effect me-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; padding: 0;">
                                                <i class="ti tabler-player-track-next" style="font-size: 18px;"></i>
                                            </button>
                                            <input type="hidden" id="selectedLanguage" name="language" value="cpp">
                                            <select id="languageSelector" class="form-select text-white border-secondary" style="width: 100px;" onchange="changeLanguage()">
                                                <option value="cpp">C++</option>
                                                <option value="csharp">C#</option>
                                                <option value="java">Java</option>
                                                <option value="python">Python</option>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" name="solution" id="solution" value="">
                                    <div id="code-editor" name="code-editor" style="flex-grow: 1; height: 100%; width: 100%;"></div>
                                    <textarea name="example[]" id="output" style='display:none' class="form-control" rows="3" placeholder="e.g. 2 4 6"></textarea>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-5 ">
                                <button type="button" class="btn btn-secondary btn-prev">Previous</button>
                                <button type="submit" class="btn btn-success btn-submit" id="btn-submit" disabled>Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<style>
    #exampleContainer,
    #accordionCustomIcon {
        scrollbar-width: thin;
        scrollbar-color: #ccc transparent;
    }

    #exampleContainer::-webkit-scrollbar,
    #accordionCustomIcon::-webkit-scrollbar {
        width: 6px;
    }

    #exampleContainer::-webkit-scrollbar-thumb,
    #accordionCustomIcon::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 4px;
    }
</style>
<script src="/assets/myjs/teacherInit.js" defer></script>