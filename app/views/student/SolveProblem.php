    <?php
    $isContest = $data['isContest'];

    if ($isContest): ?>
        <script>
            const contestStart = new Date("<?= $data['start_time'] ?>").getTime();
            const contestEnd = new Date("<?= $data['end_time'] ?>").getTime();
            const isContest = <?= json_encode($isContest) ?>;
            setCode = <?= json_encode($hasSolved ? $solution : '') ?>;
            setLanguage = <?= json_encode($hasSolved ? $language : '') ?>;
        </script>
    <?php else: ?>
        <script>
            isContest = <?= json_encode($isContest) ?>;
            setCode = <?= json_encode($submission['hasSolved'] ? $submission['solution'] : '') ?>;
            setLanguage = <?= json_encode($submission['hasSolved'] ? $submission['language'] : '') ?>;
        </script>
    <?php
        $language = $submission['language'] ?? 'cpp';
        $hasSolved = $submission['hasSolved'] ?? false;
    endif; ?>

    <div class="row">
        <div class="col-md-4 col-12" id="sidebar" style="transition: all 0.3s;">

            <div class="nav-align-top nav-tabs-shadow">
                <button id="toggleSidebar" class="btn btn-sm btn-primary mb-2 w-100 d-md-none">Toggle Sidebar</button>
                <ul class="nav nav-tabs n   av-fill" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link waves-effect active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-home" aria-controls="navs-justified-home" aria-selected="false">
                            <span class="d-none d-sm-inline-flex align-items-center">
                                <i class="icon-base fas fa-lightbulb icon-sm me-1_5"></i>Problem
                            </span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link waves-effect" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile" aria-selected="true">
                            <span class="d-none d-sm-inline-flex align-items-center"><i class="icon-base fas fa-terminal icon-sm me-1_5"></i><?php echo $isContest ? "Problems" : "Output" ?></span>
                            <i class="icon-base ti tabler-user icon-sm d-sm-none"></i>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link waves-effect" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-messages" aria-controls="navs-justified-messages" aria-selected="false">
                            <span class="d-none d-sm-inline-flex align-items-center"><i class="icon-base fas fa-vial icon-sm me-1_5"></i>Test Cases</span>
                            <i class="icon-base ti tabler-message-dots icon-sm d-sm-none"></i>
                        </button>
                    </li>
                </ul>
                <div class="tab-content" style="height: 600px;">
                    <div class="tab-pane fade active show custom-scroll" id="navs-justified-home" role="tabpanel">
                        <div class="ps" style="height: 100%; overflow-y: auto;">
                            <?php echo $isContest ? $data['current_problem']['markdown'] : $data['markdown']; ?>
                        </div>
                    </div>
                    <?php
                    if ($isContest): ?>
                        <div class="tab-pane fade custom-scroll" name="listsOfContestProblems" id="navs-justified-profile" role="tabpanel">
                            <div class="ps" style="height: 100%; overflow-y: auto;">
                                <div class="mb-3">
                                    <h6 class="text-white fw-bold mb-2">Contest Problems</h6>
                                    <div class="d-grid gap-2">
                                        <?php foreach ($problems as $problem): ?>
                                            <?php if ($data['current_problem']['slug'] === $problem['slug']) { ?>
                                                <a href="" class="btn text btn-sm btn-dark py-3 text-white  w-100 mb-2 active text-start">
                                                    <?= htmlspecialchars($problem['title']) ?> — <small class="text-muted"><?= $problem['total_score'] ?> pts</small>
                                                </a>
                                            <?php } else { ?>
                                                <a href="/contest/<?= $data['contest'][0]['id'] ?>/<?= $problem['id'] ?>" class="btn text btn-sm btn-outline-primary py-3 text-white  w-100 mb-2 active text-start">
                                                    <?= htmlspecialchars($problem['title']) ?> — <small class="text-muted"><?= $problem['total_score'] ?> pts</small>
                                                </a>
                                            <?php } ?>
                                        <?php endforeach; ?>
                                        <form action="/contest/<?= $data['contest'][0]['id'] ?>/finished" id="finish-form" method="post" class="finish-form mt-5">
                                            <input type="hidden" name="problem_total_score" value="<?= $current_problem['total_score'] ?>">
                                            <input type="hidden" id="isFinished" name="isFinished" value="<?= $current_problem['total_score'] ?>">
                                            <button type="button" class="btn btn-danger btn-sm w-100 py-3 finish-button">
                                                Finish Contest
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="tab-pane fade custom-scroll" <?= $isContest ? 'hidden' : '' ?> id="navs-justified-profile" role="tabpanel">
                        <div class="ps" style="height: 100%; overflow-y: auto;">
                            <div class="ps">
                                <textarea id="argsInput" class="form-control text-white border-0 mb-4" rows="2"
                                    style="resize: none; background-color: #282a36;" placeholder="e.g., 5 10"></textarea>
                                <textarea id="output" disabled class="form-control text-white border-0" style="resize:none; background-color:#282a36; height: 450px;"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade custom-scroll" id="navs-justified-messages" role="tabpanel">
                        <div class="ps" style="height: 100%; overflow-y: auto;">

                            <div class="" <?= !$isContest ? 'hidden' : '' ?>>
                                <div id="totalScoreContainer" class="d-flex align-items-center mb-3">
                                    <i id="totalScoreIcon" class="fas fa-star me-2 text-warning"></i>
                                    <span class="text-white fw-bold" id="totalScoreLabel">Total Score: 0</span>
                                </div>
                            </div>
                            <div id="accordionCustomIcon" class="accordion mt-3  accordion-custom-button">
                                <!-- test cases -->

                                <?php foreach ($data['testCases'] as $index => $testCases): ?>
                                    <?php $accordionId = 'accordionCustomIcon-' . $index; ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header text-body d-flex justify-content-between align-items-center" id="accordionHeader-<?php echo $index ?>">
                                            <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                                data-bs-target="#<?php echo $accordionId ?>" aria-controls="<?php echo $accordionId ?>" aria-expanded="false">
                                                <i class="icon-base  me-2 fas fa-circle-minus text-secondary"></i>
                                                Test Case <?php echo $index + 1; ?>
                                            </button>
                                        </h2>
                                        <div id="<?php echo $accordionId ?>" class="accordion-collapse collapse" data-bs-parent="#accordionCustomIcon">
                                            <div class="accordion-body">
                                                <label class="form-label fw-bold text-white small">Input</label>
                                                <textarea class="form-control text-white border-0 mb-2 small" disabled style="resize: none; background-color: #282a36; font-size: 0.85rem;"><?php echo $testCases['input'] ?></textarea>

                                                <label class="form-label fw-bold text-white small">Expected Output</label>
                                                <textarea class="form-control text-white border-0 mb-2 small" disabled style="resize: none; background-color: #282a36; font-size: 0.85rem;"><?php echo $testCases['output'] ?></textarea>

                                                <label class="form-label fw-bold text-white small">Your Output</label>
                                                <textarea class="form-control text-white border-0 small" disabled style="resize: none; background-color: #282a36; font-size: 0.85rem;"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-8 col-12 editor-main d-flex flex-column" id="mainContent" style="transition: all 0.3s; height: 100vh; overflow-y: auto;">
            <div class="col-12">
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar bg-success" id="progressBar" role="progressbar"
                        style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                <!-- Left Section: Code Editor Title -->
                <h5 class="mb-0">Code Editor</h5>

                <!-- Center Section: Timer -->
                <div class="d-flex justify-content-center align-items-center flex-grow-1">
                    <div id="countdown-timer" class="border rounded py-2 px-4" style="font-size: 20px; font-weight: bold;" <?= $isContest ? '' : 'hidden' ?>></div>
                </div>
                <form action="submit-problem/<?= $isContest ? $current_problem['id'] : ($_SESSION['user']['user_id']) ?>" method="POST" onsubmit="return updateCodeBeforeSubmit() 
                && calculateScore(<?= $current_problem['score_per_testcase'] ?>);">

                    <input type="hidden" id="solution" name="solution" value="">
                    <input type="hidden" id="contestSolution" name="contestSolution" value="">

                    <input type="hidden" id="score" name="score" value="">
                    <input type="hidden" id="totalScore" name="totalScore" value="">
                    <div class="d-flex align-items-center mt-3">

                        <button type="button" class="btn btn-outline-danger waves-effect me-2 d-flex align-items-center justify-content-center lock-toggle" style="width: 36px; height: 36px; padding: 0;">
                            <i class="ti tabler-lock" style="font-size: 18px;"></i>
                        </button>
                        <button type="submit" class="btn btn-success mx-3 btn-submit target-button" id="btn-submit" disabled>Submit Solution</button>
                        <button type="button" onclick="runBatchCode();" id="btnRunBatch" class="btn btn-outline-info waves-effect me-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; padding: 0;">
                            <i class="ti tabler-player-track-next" style="font-size: 18px;"></i>
                        </button>
                        <input type="hidden" id="contest_slug" name="contest_slug" value="<?= $isContest ? $data['problems'][0]['slug'] : $data['slug'] ?>">
                        <input type="hidden" id="selectedLanguage" name="language" value="cpp">
                        <select id="languageSelector" class="form-select text-white border-secondary" style="width: 110px;" onchange="changeLanguage()">
                            <option value="cpp" <?= $hasSolved && $language === 'C++' ? 'selected' : ''; ?>>C++</option>
                            <option value="csharp" <?= $hasSolved && $language === 'C#' ? 'selected' : ''; ?>>C#</option>
                            <option value="java" <?= $hasSolved && $language === 'Java' ? 'selected' : ''; ?>>Java</option>
                            <option value="python" <?= $hasSolved && $language === 'Python' ? 'selected' : ''; ?>>Python</option>
                        </select>
                    </div>

            </div>

            <div id="code-editor" style="flex-grow: 1; height: 100%; width: 100%;">

            </div>
            </form>
            <div class="p-3 border-top">

            </div>
        </div>


        <style>
            #toastContainer {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                width: 300px;
            }

            .toast {
                margin-bottom: 1rem;
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
                border: none;
                overflow: hidden;
            }

            .toast-header {
                font-weight: 600;
            }

            .toast-body {
                padding: 1rem;
            }

            #sidebar.collapsed {
                width: 60px;
                overflow: hidden;
            }

            #mainContent.collapsed {
                margin-left: 70px;
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                #sidebar {
                    width: 100%;
                    height: auto;
                }

                #mainContent {
                    margin-left: 0;
                }
            }

            /* Scrollbar styles */
            .custom-scroll {
                overflow-y: auto;
                max-height: 450px;
            }

            .custom-scroll::-webkit-scrollbar {
                width: 6px;
            }

            .custom-scroll::-webkit-scrollbar-thumb {
                background-color: #ccc;
                border-radius: 4px;
            }

            .custom-scroll::-webkit-scrollbar-thumb:hover {
                background-color: #999;
            }
        </style>

        <script>
            const countdownDisplay = document.getElementById("countdown-timer");
            const finishForm = document.getElementById("finish-form");
            const form = document.querySelector('form[action^="submit-problem"]');
            const scoreInput = form.querySelector('input[name="score"]');
            const totalScoreLabel = document.getElementById('totalScoreLabel');

            form.addEventListener('submit', (e) => {
                let scoreText = totalScoreLabel.textContent || "";

                let match = scoreText.match(/Total Score:\s*([\d\/]+)/);
                let totalScore = match ? match[1] : "0/0";


                scoreInput.value = totalScore;

                console.log('Submitting score:', totalScore);


            });


            if (isContest) {
                const updateCountdown = () => {
                    const now = new Date().getTime();

                    let timeLeft, label;
                    if (now < contestStart) {
                        timeLeft = contestStart - now;
                        label = "Contest starts in: ";
                    } else if (now < contestEnd) {
                        timeLeft = contestEnd - now;
                        label = "";
                    } else {
                        countdownDisplay.textContent = "Contest Ended";
                        clearInterval(timerInterval);

                        const isFinishedInput = document.getElementById("isFinished");
                        if (isFinishedInput) {
                            isFinishedInput.value = "true";
                        }
                        finishForm.submit()
                        return;
                    }

                    const totalSeconds = Math.floor(timeLeft / 1000);
                    const hours = String(Math.floor(totalSeconds / 3600)).padStart(2, '0');
                    const minutes = String(Math.floor((totalSeconds % 3600) / 60)).padStart(2, '0');
                    const seconds = String(totalSeconds % 60).padStart(2, '0');

                    countdownDisplay.textContent = label + hours + ":" + minutes + ":" + seconds;
                };

                const timerInterval = setInterval(updateCountdown, 1000);
                updateCountdown();
            }
            document.querySelectorAll('.finish-button').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    Swal.fire({
                        title: 'Finish contest?',
                        text: "Are you sure you want to finish this contest? This action cannot be undone.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#aaa',
                        confirmButtonText: 'Yes, finish it!',
                        customClass: {
                            confirmButton: 'btn btn-danger me-1',
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
            document.querySelectorAll('.lock-toggle').forEach(lockButton => {
                lockButton.addEventListener('click', function() {
                    const icon = this.querySelector('i');
                    const isUnlocked = icon.classList.contains('tabler-lock-open');

                    Swal.fire({
                        title: isUnlocked ? 'Lock this?' : "You're almost there!",
                        text: isUnlocked ?
                            "Locking will disable the submit button. Are you sure you want to lock it now?" : "Hey, you haven't solved all the test cases yet!, Are you sure you want to unlock and submit now?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: isUnlocked ? 'Yes, lock it!' : "I’m ready to submit!",
                        customClass: {
                            confirmButton: 'btn btn-primary me-1',
                            cancelButton: 'btn btn-label-secondary'
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {

                            icon.classList.toggle('tabler-lock');
                            icon.classList.toggle('tabler-lock-open');


                            const submitButton = document.getElementById('btn-submit');
                            if (submitButton) {
                                submitButton.disabled = isUnlocked;
                            }
                        }
                    });
                });
            });



            function updateCodeBeforeSubmit() {
                document.getElementById("contestSolution").value = editor.getValue();
                console.log("Code submitted:", editor.getValue());
                return true;
            }

            function calculateScore(score_per_testcase) {
                const score = document.getElementById("score").value;
                const finalScore = score_per_testcase * score;

                document.getElementById("totalScore").value = finalScore;
                console.log("score:", finalScore);
                return true;
            }
        </script>