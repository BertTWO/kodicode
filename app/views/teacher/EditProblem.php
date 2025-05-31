<?php
//var_dump($data['parsed']['examples'][1]);
//var_dump($data['testCases'][0]['output']);

?>

<div class="row">

</div>
<div class="col-xxl">
    <div class="card">
        <h5 class="card-header">Edit <?php echo htmlspecialchars($data['problem'][0]['title']); ?></h5>
        <form class="card-body" method="post" id="editProblemForm">
            <h6>1. Problem Details</h6>
            <div class="row mb-6">
                <label class="col-sm-3 col-form-label text-sm-end" for="alignment-username">Title</label>
                <div class="col-sm-9">
                    <input type="text" name="title" id="alignment-username" class="form-control" placeholder="Rever String" value="<?php echo htmlspecialchars($problem[0]['title']); ?>">
                </div>
            </div>
            <div class="row mb-6">
                <label class="col-sm-3 col-form-label text-sm-end" for="alignment-email">Email</label>
                <div class="col-sm-9">
                    <select class="form-select" name="difficulty" id="difficulty">
                        <option value="Easy" <?= $problem[0]['difficulty'] === 'Easy' ? 'selected' : '' ?>>Easy</option>
                        <option value="Medium" <?= $problem[0]['difficulty'] === 'Medium' ? 'selected' : '' ?>>Medium</option>
                        <option value="Hard" <?= $problem[0]['difficulty'] === 'Hard' ? 'selected' : '' ?>>Hard</option>
                    </select>
                </div>
            </div>
            <div class="row mb-6">  
                <label class="col-sm-3 col-form-label text-sm-end" for="alignment-username">Description</label>
                <div class="col-sm-9">
                      <textarea name="description" id="problem-description" class="form-control mb-5" rows="5" placeholder="e.g. Given a list of numbers, return their sum."><?php echo htmlspecialchars($parsed['description'])?></textarea>
                </div>
            </div>
            <div class="row mb-6 form-password-toggle">
                <label class="col-sm-3 col-form-label text-sm-end" for="alignment-password">Examples</label>
                <div class="col-sm-9">
                    <div id="editExampleContainer" class="mb-3" style="max-height: 450px; overflow-y: auto;">
                        <div class="card border rounded shadow-sm example-pair mb-2 shadow-sm p-3">

                            <?php foreach ($parsed['examples'] as $example) : ?>
                                <div class="mb-2">
                                    <textarea name="example[]" class="form-control" rows="3" style="background-color: #282a36; color: #fff;" placeholder="e.g. 2 4 6"><?php echo htmlspecialchars($example); ?></textarea>
                                </div>
                                <button type="button" class="btn btn-outline-danger btn-sm remove-edit-example">
                                    <i class="bi bi-x-circle"></i> Remove Example
                                </button>

                            <?php endforeach; ?>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-success mb-4 mx-3" id="addEditExample">
                        <i class="bi bi-plus-circle"></i> Add Example
                    </button>
                </div>
            </div>

            <hr class="my-6 mx-n6">

            <h6 class="mb-3">
                <i class="bi bi-bug me-1"></i> 2. Update Test Cases
            </h6>
            <div class="row mb-4">
                <label class="col-sm-3 col-form-label text-sm-end">Test Cases</label>
                <div class="col-sm-9">
                    <div class="card border rounded shadow-sm">
                        <div class="card-body p-3" style="max-height: 350px; overflow-y: auto;" id="testCaseScrollArea">
                            <div id="accordionCustomIcon" class="accordion accordion-flush">
                                <?php foreach ($testCases as $index => $testcase) : ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header text-body d-flex justify-content-between align-items-center">
                                            <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionCustomIcon-<?php echo $index; ?>" aria-controls="accordionCustomIcon-<?php echo $index; ?>" aria-expanded="false">
                                                <i class="icon-base me-2 fas fa-circle-minus text-secondary"></i>
                                                Test Case <?php echo $index + 1; ?>
                                            </button>
                                        </h2>
                                        <div id="accordionCustomIcon-<?php echo $index; ?>" class="accordion-collapse collapse" data-bs-parent="#accordionCustomIcon">
                                            <div class="accordion-body">
                                                <label class="form-label fw-bold text-white small">Input</label>
                                                <textarea name="input[]" class="form-control text-white border-0 mb-2 small" style="resize: none; background-color: #282a36; font-size: 0.85rem;" placeholder="e.g., 1 2 3"><?php echo htmlspecialchars($testcase["input"]); ?></textarea>

                                                <label class="form-label fw-bold text-white small">Expected Output</label>
                                                <textarea name="expectedOutput[]" class="form-control text-white border-0 mb-2 small" style="resize: none; background-color: #282a36; font-size: 0.85rem;" placeholder="e.g., 6"><?php echo htmlspecialchars($testcase["output"]); ?></textarea>

                                                <label class="form-label fw-bold text-white small">Your Output</label>
                                                <textarea class="form-control text-white border-0 small" disabled style="resize: none; background-color: #282a36; font-size: 0.85rem;"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-start mt-3 gap-2">
                        <button type="button" class="btn btn-outline-success" id="addTestCaseBtn">
                            <i class="bi bi-plus-circle me-1"></i> Add Test Case
                        </button>
                        <button type="button" class="btn btn-outline-danger" id="resetTestCaseBtn">
                            <i class="bi bi-x-circle me-1"></i> Reset
                        </button>
                    </div>
                </div>
            </div>

            <hr class="my-6 mx-n6">
            <h6 class="mb-3">
                <i class="bi bi-bug me-1"></i> 3. Update Solution
            </h6>

            <div class="row mb-4">

                <div class="row mb-5 align-items-stretch">

                    <div class="col-md-4 mb-3 d-flex flex-column" style="margin-top:45px; overflow-y: auto;">
                        <h5 class="mb-0">Code Editor</h5>
                        <textarea name="" style="background-color: #282a36; color: #fff;" id="output" class="form-control flex-grow-1" placeholder="e.g. 2 4 6"></textarea>
                    </div>

                    <div class="col-md-8">
                        <div class="editor-main d-flex flex-column h-100" id="mainContent" style="transition: all 0.3s; min-height: 500px; overflow-y: auto;">
                            <!-- Progress Bar -->
                            <div class="progress mb-2" style="height: 6px;">
                                <div class="progress-bar bg-success" id="progressBar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <!-- Toolbar -->
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

                            <!-- Code Editor -->
                            <input type="hidden" name="solution" id="solution" value="">
                            <div id="code-editor" name="code-editor" style="flex-grow: 1; height: 100%; min-height: 400px; width: 100%;"></div>
                        </div>
                    </div>
                </div>


                <div class="pt-6">
                    <div class="row justify-content-end">
                        <div class="col-sm-9">
                            <button type="submit" id="btn-submit" class="btn btn-primary me-4 waves-effect waves-light" disabled>Update</button>
                            <button type="reset" class="btn btn-label-secondary waves-effect">Cancel</button>
                        </div>
                    </div>
                </div>
        </form>
    </div>
</div>
</row>
<style>

</style>
<script src="/assets/myjs/editproblem.js" defer></script>