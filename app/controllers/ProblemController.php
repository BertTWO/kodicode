<?php
require_once BASE_PATH . 'core/Controller.php';
require_once BASE_PATH . 'vendor/erusev/parsedown/Parsedown.php';

class ProblemController extends Controller
{
    public function viewProblem($slug)
    {
        $this->redirectIfNotAuthenticated();

        $problemDir = BASE_PATH . "app/problems/$slug/";
        $problemPath = $problemDir . "problem.md";
        $inputsPath = $problemDir . "inputs/";
        $outputsPath = $problemDir . "outputs/";

        if (!file_exists($problemPath)) {
            echo "Problem not found.";
            return;
        }

        $markdown = file_get_contents($problemPath);
        $Parsedown = new Parsedown();
        $html = $Parsedown->text($markdown);

        $problemId = (new Problem())->getProblemBySlug($slug)[0]['id'];
        $testCases = [];
        $submission = $this->getSubmissionData($_SESSION['user']['user_id'], $problemId, $slug);

        $submission['hasSolved'] = ($submission && $submission['language'] !== null ? true : false);

        if (is_dir($inputsPath) && is_dir($outputsPath)) {
            $testCases = $this->getTestCases($inputsPath, $outputsPath);
        }

        $this->viewAsStudent("student/SolveProblem", [
            'markdown' => $html,
            'slug' => $slug,
            'testCases' => $testCases,
            'isContest' => false,
            'submission' => $submission
        ]);
    }

    protected function getSubmissionData($student_id, $problem_id, $slug)
    {

        $submission = (new Submission())->getAllWithCondition("student_id = $student_id AND problem_id = $problem_id AND contest_id IS NULL");

        if ($submission) {
            $languageExtMap = array_flip($this->languageMap);
            $lang = $languageExtMap[$submission[0]['language']];
            $solution =  "solution." . $lang;

            $submissionPath = BASE_PATH . "app/submissions/user_$student_id/$slug/$solution";

            $content = file_get_contents($submissionPath);

            return [
                "solution" => $content,
                "language" => $this->languageMap[$lang]
            ];
        }
        return [];
    }

    public function handleCreateProblem()
    {
        $this->redirectIfNotAuthenticated();

        $slug = strtolower(str_replace(' ', '-', $_POST['title']));
        $problemData = [
            'slug' => $slug,
            'title' => $_POST['title'],
            'difficulty' => strtolower($_POST['difficulty']),
            'teacher_id' => $_SESSION['user']['user_id']
        ];
        $problemTestCases = [
            'input' => $_POST['input'],
            'output' => $_POST['expectedOutput']
        ];
        $problemMdContent = [
            'slug' => $slug,
            'description' => $_POST['description'],
            'title' => $_POST['title'],
            'example' => $_POST['example'],
        ];

        $this->addTestCases($slug, $problemTestCases);
        $this->createProblemMdStructure($problemMdContent);
        $this->createSolutionFile($slug, $_POST['solution'], $_POST['language']);
        $problem = new Problem();
        $problem->createProblem($problemData);

        var_dump($_POST['solution']);
        header("Location: /teacher/manage-problems");
        exit;
    }

    private function createProblemMdStructure($data)
    {

        $problemDir = BASE_PATH . "app/problems/" . $data['slug'] . "/";
        $content = $this->getProblemMdContent($data);

        file_put_contents($problemDir . "problem.md", $content);
    }

    private function getProblemMdContent($data)
    {
        $content = "### " . $data['title'] . "\n\n";
        $content .= $data['description'] . "\n\n";
        $content .= "---";

        for ($i = 0; $i < count($data['example']); $i++) {
            $content .= "\n\n##### Example " . ($i + 1) . "\n```\n" . $data['example'][$i] . "\n```";
        }

        return $content;
    }

    private function updateTestCases($inputDir, $outputDir, $testCases)
    {
        $existingInputFiles = glob($inputDir . '*.txt');
        $existingOutputFiles = glob($outputDir . '*.txt');

        $newTestCaseCount = count($testCases['input']);
        $existingTestCaseCount = count($existingInputFiles);

        if ($existingTestCaseCount > $newTestCaseCount) {
            for ($i = $newTestCaseCount; $i < $existingTestCaseCount; $i++) {
                $inputFile = $inputDir . "input$i.txt";
                $outputFile = $outputDir . "output$i.txt";

                if (file_exists($inputFile)) {
                    unlink($inputFile);
                }
                if (file_exists($outputFile)) {
                    unlink($outputFile);
                }
            }
        }

        for ($i = 0; $i < $newTestCaseCount; $i++) {
            $inputFile = $inputDir . "input$i.txt";
            $outputFile = $outputDir . "output$i.txt";

            file_put_contents($inputFile, $testCases['input'][$i]);
            file_put_contents($outputFile, $testCases['output'][$i]);
        }
    }
    private function addTestCases($slug, $testCases)
    {
        $problemDir = BASE_PATH . "app/problems/$slug";
        $inputDir = $problemDir . "/inputs/";
        $outputDir = $problemDir . "/outputs/";

        if (!is_dir($problemDir)) {
            mkdir($problemDir, 0777, true);
            mkdir($inputDir, 0777, true);
            mkdir($outputDir, 0777, true);
        }
        for ($i = 0; $i < count($testCases['input']); $i++) {
            $inputFile = $inputDir . 'input' . $i . '.txt';
            $outputFile = $outputDir . 'output' . $i . '.txt';

            file_put_contents($inputFile, $testCases['input'][$i]);
            file_put_contents($outputFile, $testCases['output'][$i]);
        }
    }

    private function getTestCases($inputsPath, $outputsPath)
    {
        $testCases = [];

        $inputFiles = glob($inputsPath . '*.txt');
        $outputFiles = glob($outputsPath . '*.txt');

        foreach ($inputFiles as $inputFile) {

            $baseName = basename($inputFile, '.txt');

            $outputFile = $outputsPath . 'output' . substr($baseName, -1) . '.txt';

            if (file_exists($outputFile)) {
                $testCases[] = [
                    'name' => 'Test Case ' . (count($testCases) + 1),
                    'input' => file_get_contents($inputFile),
                    'output' => file_get_contents($outputFile),
                ];
            }
        }

        return $testCases;
    }

    private function createSolutionFile($slug, $solution, $language)
    {
        $problemDir = BASE_PATH . "app/problems/$slug/solutions/";
        $solutionFile = $problemDir . "solution.$language";
        if (!is_dir($problemDir)) {
            mkdir($problemDir, 0777, true);
        }
        file_put_contents($solutionFile, $solution);
    }

    private function deleteDirectory($dir)
    {
        if (!is_dir($dir)) {
            return false;
        }

        $items = array_diff(scandir($dir), ['.', '..']);
        foreach ($items as $item) {
            $path = $dir . DIRECTORY_SEPARATOR . $item;
            if (is_dir($path)) {
                $this->deleteDirectory($path);
            } else {
                unlink($path);
            }
        }

        return rmdir($dir);
    }

    public function handleDeleteProblem($slug)
    {
        $this->redirectIfNotAuthenticated();

        $problemDir = BASE_PATH . "app/problems/$slug/";

        if (is_dir($problemDir)) {
            $this->deleteDirectory($problemDir); // Use the recursive delete function
        }

        $problem = new Problem();
        $problem->deleteProblem($slug);

        header("Location: /teacher/manage-problems");
        exit;
    }

    private function parseProblemMd($markdown)
    {
        $parsed = [
            'title' => '',
            'description' => '',
            'examples' => []
        ];


        if (preg_match('/^###\s+(.*)$/m', $markdown, $matches)) {
            $parsed['title'] = trim($matches[1]);
        }


        if (preg_match('/^###\s+.*?\n+(.*?)\n+---/s', $markdown, $matches)) {
            $parsed['description'] = trim($matches[1]);
        }
        preg_match_all('/#####\s+Example\s+\d+\s+```(.*?)```/s', $markdown, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $exampleBlock) {
                $parsed['examples'][] = trim($exampleBlock);
            }
        }

        return $parsed;
    }


    public function viewProblemUpdate($slug)
    {
        $this->redirectIfNotAuthenticated();

        $problemPath = BASE_PATH . "app/problems/$slug/problem.md";

        if (!file_exists($problemPath)) {
            echo "Problem not found.";
            return;
        }

        $markdown = file_get_contents($problemPath);
        $parsed = $this->parseProblemMd($markdown);

        $testCases = $this->getTestCases(
            BASE_PATH . "app/problems/$slug/inputs/",
            BASE_PATH . "app/problems/$slug/outputs/"
        );

        $problem = (new Problem())->getProblemBySlug($slug);

        $this->viewAsTeacher('teacher/editProblem', [
            'markdown' => $markdown,
            'slug' => $slug,
            'parsed' => $parsed,
            'problem' => $problem,
            'testCases' => $testCases
        ]);
    }

    public function handleUpdateProblem($slug)
    {
        $this->redirectIfNotAuthenticated();

        $problemDir = BASE_PATH . "app/problems/$slug/";
        $inputDir = $problemDir . "inputs/";
        $outputDir = $problemDir . "outputs/";
        $solutionDir = $problemDir . "solutions/";


        $newSlug = strtolower(str_replace(' ', '-', $_POST['title']));

        if ($slug !== $newSlug) {
            $newProblemDir = BASE_PATH . "app/problems/$newSlug/";

            // Rename the directory
            if (is_dir($problemDir)) {
                rename($problemDir, $newProblemDir);
            }


            $problemDir = $newProblemDir;
            $inputDir = $problemDir . "inputs/";
            $outputDir = $problemDir . "outputs/";
            $solutionDir = $problemDir . "solutions/";
        }

        $problemMdContent = [
            'slug' => $newSlug,
            'description' => $_POST['description'],
            'title' => $_POST['title'],
            'example' => $_POST['example'],
        ];
        $this->createProblemMdStructure($problemMdContent);


        $problemTestCases = [
            'input' => $_POST['input'],
            'output' => $_POST['expectedOutput']
        ];
        $this->updateTestCases($inputDir, $outputDir, $problemTestCases);


        $this->createSolutionFile($newSlug, $_POST['solution'], $_POST['language']);


        $problemData = [
            'slug' => $newSlug,
            'title' => $_POST['title'],
            'difficulty' => strtolower($_POST['difficulty']),
            'is_public' => isset($_POST['is_public']) ? true : false,
            'teacher_id' => $_SESSION['user']['user_id']
        ];
        $problem = new Problem();
        $result = $problem->updateProblem($slug, $problemData); // Use the old slug to find the record

        if (!$result) {
            var_dump($problemData);
            exit;
        }

        header("Location: /teacher/manage-problems");
        exit;
    }

    public function viewProblemList()
    {
        $this->redirectIfNotAuthenticated();

        $problems = (new Problem())->getAllPublicProblems();
        $solvedProblems = (new Submission())->getAllSolvedProblems($_SESSION['user']['user_id']);
        $this->viewAsStudent('student/Problems', [
            'problems' => $problems,
            'solvedProblems' => $solvedProblems
        ]);
    }
    public function handleSubmitProblem() {}
}
