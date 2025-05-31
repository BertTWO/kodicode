<?php
require_once BASE_PATH . 'core/Controller.php';

class SubmissionController extends Controller
{
    public function handleCreateSubmission($id)
    {
        $code = $_POST['solution'];
        $lang = $_POST['language'];
        $slug = $_POST['contest_slug'];
        $student_id = $_SESSION['user']['user_id'];
        $submissionPath = BASE_PATH . 'app/submissions/user_' . $student_id . '/' . $slug . '/';
        $submissionFile =  "solution.$lang";

        $submission = new Submission();
        $this->createSubmissionFile($submissionPath, $submissionFile, $code);

        $problem_id = ((new Problem())->getAllByColumn('slug', $slug))[0]['id'];

        $language = $this->languageMap[$lang] ?? '';

        $submissionData = [
            'student_id' => $student_id,
            'problem_id' => $problem_id,
            'submission_path' => $submissionPath,
            'language' => $language,
            'score' => 0
        ];

        $submissionExists = (new Submission())->getAllWithCondition("student_id = $id AND problem_id = $problem_id AND contest_id IS NULL");

        if ($submissionExists) {

            $submission->update(
                $submissionExists[0]['id'],
                [
                    'submission_path' => $submissionPath,
                    'language' => $language,
                    'score' => 0,
                ],
                'id'
            );
        } else {
            $submission->nonContestCreateSubmission($submissionData);
        }

        header('Location: /student/problems');
    }
    protected function createSubmissionFile($filePath, $fileName, $code)
    {
        $submissionFile = $filePath . $fileName;

        if (!is_dir($filePath)) {
            mkdir($filePath, 0777, true);
        }

        file_put_contents($submissionFile, $code);
    }
    public function handleContestSubmission($contestId, $problemId)
    {

        $code = $_POST['contestSolution'];
        $slug = $_POST['contest_slug'];
        $lang = $_POST['language'];
        $student_id = $_SESSION['user']['user_id'];
        $score = $_POST['totalScore'];
        $submissionPath = BASE_PATH . 'app/contest-submission/contest_' . $contestId . '/user_' . $student_id . '/' . $slug . '/';

        $langName = $this->languageMap[$lang];

        $submission = new Submission();

        $submissionExisted = (new Submission())->getAllWithCondition("contest_id = $contestId AND student_id = $student_id AND problem_id = $problemId");

        if ($submissionExisted) {
            $submission->update(
                $submissionExisted[0]['id'],
                [
                    'submission_path' => $submissionPath,
                    'language' => $langName,
                    'score' => $score,
                ],
                'id'
            );
        } else {
            $submission->insert([
                "contest_id" => $contestId,
                'student_id' => $student_id,
                'problem_id' => $problemId,
                'submission_path' => $submissionPath,
                'language' => $langName,
                'score' => round($score),
            ]);
        }
        $this->createSubmissionFile($submissionPath, 'contest-solution.' . $lang, $code);

        header('Location: /contest/' . $contestId . '/' . $problemId);
    }
}
