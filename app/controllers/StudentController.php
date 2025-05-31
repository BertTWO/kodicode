<?php
require_once BASE_PATH . 'core/Controller.php';
require_once BASE_PATH . 'vendor/erusev/parsedown/Parsedown.php';
class StudentController extends Controller
{
    public function dashboard()
    {
        $this->redirectIfNotAuthenticated();
        $contests = (new Contest())->getAll();
        $profile = (new Student())->getProfileInfo($_SESSION['user']['user_id']);
        $contest_id = array_column($contests, 'id');
        $firstProblem = (new ContestProblem())->getAllByColumnIn('contest_id', $contest_id);
        $joinedContests = (new Participants())->joinedContests($_SESSION['user']['user_id'], $contests);

        $this->viewAsStudent('student/Dashboard', [
            $this->normalizeProfileData($profile),
            'contests' => $contests,
            'has_joined' => $joinedContests,
            'firstProblem' => $firstProblem
        ]);
    }
    public function viewFinishedContests()
    {
        $this->viewAsStudent('student/Finish');
    }

    public function viewPlayground()
    {
        $this->redirectIfNotAuthenticated();
        $this->viewAsStudent('student/Playground');
    }
    public function viewProblems()
    {
        $this->redirectIfNotAuthenticated();
        $this->viewAsStudent('student/Problems');
    }

    public function viewProfile()
    {

        $this->redirectIfNotAuthenticated();
        $profile = (new Student())->getProfileInfo($_SESSION['user']['user_id']);

        $this->viewAsStudent('components/profile', $this->normalizeProfileData($profile));
    }

    protected function getSolution($language, $filePath)
    {
        $newLanguageMap = array_flip($this->languageMap);
        $language = $newLanguageMap[$language] ?? '';

        $solutionPath = $filePath . "contest-solution.$language";
        if (!file_exists($solutionPath)) {
            return '';
        }

        return file_get_contents($solutionPath);
    }

    public function viewContest($contestId, $problemId)
    {
        $contest = (new Contest())->getAllByColumn('id', $contestId);
        $contestProblems = (new ContestProblem())->getAllByColumn('contest_id', $contestId);
        $problemIds = array_column($contestProblems, 'problem_id');
        $totalScores = array_column($contestProblems, 'total_score');
        $problems = (new Problem())->getAllByColumnIn('id', $problemIds);

        $submission = (new Submission())->getAllWithCondition("contest_id = $contestId AND problem_id = $problemId AND student_id = {$_SESSION['user']['user_id']}");

        if ($submission) {
            $solutionContent = $this->getSolution($submission[0]['language'], $submission[0]['submission_path']);
        }

        $hasSolved = $submission ? true : false;
        foreach ($problems as &$problem) {
            $problem['testcases_count'] = $this->countTestCases($problem['slug']);
            $problem['markdown'] = $this->getMarkdown($problem['slug']);

            foreach ($contestProblems as $cp) {
                if ($cp['problem_id'] == $problem['id']) {
                    $problem['total_score'] = $cp['total_score'];
                    break;
                }
            }

            $problem['score_per_testcase'] = $problem['testcases_count'] > 0
                ? round($problem['total_score'] / $problem['testcases_count'], 2)
                : 0;

            if ($problem['id'] == $problemId) {
                $selectedProblem = $problem;
            }
        }
        unset($problem);

        $testCases = $this->getTestCases($selectedProblem['slug']);

        $contestData = [
            'contest' => $contest,
            'problems' => $problems,
            'current_problem' => $selectedProblem,
            'start_time' => $contest[0]['start_time'],
            'end_time' => $contest[0]['end_time'],
            'testCases' => $testCases,
            'isContest' => true,
            'hasSolved' => $hasSolved,
            'solution' => $solutionContent ?? '',
            'language' => $submission[0]['language'] ?? '',
        ];

        $this->viewAsStudent('student/SolveProblem', $contestData);
    }
    protected function getTestCases($slug)
    {
        $inputsPath = BASE_PATH . "app/problems/$slug/inputs/";
        $outputsPath = BASE_PATH . "app/problems/$slug/outputs/";

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
    protected function getMarkdown($slug)
    {
        $problemPath = BASE_PATH . "app/problems/$slug/problem.md";
        $markdown = file_get_contents($problemPath);
        $Parsedown = new Parsedown();
        return $Parsedown->text($markdown);
    }

    public function countTestCases($slug)
    {
        $inputFolder =  BASE_PATH . "app/problems/$slug/inputs";
        if (!is_dir($inputFolder)) {
            return 0;
        }
        $files = scandir($inputFolder);

        $inputFiles = array_filter($files, function ($file) use ($inputFolder) {
            return is_file("$inputFolder/$file");
        });

        return count($inputFiles);
    }

    public function handleProfile()
    {
        $this->redirectIfNotAuthenticated();

        $user_id = $_SESSION['user']['user_id'];
        $data = $this->getProfileDataFromPost();

        if ($this->isValidImageUpload()) {
            $this->processProfileImage($user_id, $data);
        }

        (new Student())->save($user_id, $data);
        $profile = (new Student())->getProfileInfo($user_id);

        $this->viewAsStudent('components/profile', $this->normalizeProfileData($profile));
        exit;
    }



    protected function getProfileDataFromPost()
    {
        return [
            'firstname'  => $_POST['firstName'] ?? '',
            'lastname'   => $_POST['lastName'] ?? '',
            'bio'        => $_POST['bio'] ?? '',
            'address'    => $_POST['address'] ?? '',
            'contact_no' => $_POST['contact'] ?? ''
        ];
    }

    protected function processProfileImage($user_id, &$data)
    {
        $student = new Student();
        $currentProfile = $student->getProfileInfo($user_id);

        $this->removeExistingImage($currentProfile['profile_picture'] ?? '');
        $filename = $this->uploadImage($user_id);

        if ($filename) {
            $data['profile_picture'] = '/uploads/' . $filename;
        }
    }

    protected function removeExistingImage($imagePath)
    {
        if (!empty($imagePath)) {
            $fullPath = BASE_PATH . $imagePath;
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
    }

    protected function isValidImageUpload()
    {
        if (!isset($_FILES['profile_image']) || $_FILES['profile_image']['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        return $this->isAllowedImageType() && $this->isValidImageSize();
    }

    protected function isAllowedImageType()
    {
        $allowed = ['jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));
        return in_array($ext, $allowed);
    }

    protected function isValidImageSize()
    {
        return $_FILES['profile_image']['size'] <= 2 * 1024 * 1024;
    }

    protected function uploadImage($user_id)
    {
        $uploadDir = BASE_PATH . 'public/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $ext = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));
        $filename = "user_{$user_id}_" . time() . '.' . $ext;

        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadDir . $filename)) {
            return $filename;
        }

        return null;
    }

    protected function normalizeProfileData($profile)
    {
        if ($profile) {
            $profile['profile_picture'] = $profile['profile_picture'] ?? '/uploads/noProfile.png';
        }
        $_SESSION['user_profile'] = $profile;
        return $profile;
    }
}
