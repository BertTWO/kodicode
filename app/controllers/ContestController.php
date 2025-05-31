<?php
require_once BASE_PATH . 'core/Controller.php';

class ContestController extends Controller
{
    public function handleCreateContest()
    {
        $selectedProblems = $_POST['selectedProblems'];

        $contestInfo = [
            'name' => $_POST['contest-name'],
            'is_team_based' => ($_POST['contest-type'] === 'solo' ? false : true),
            'start_time' => $_POST['start_time'],
            'end_time' => $_POST['end_time'],
            'teacher_id' => $_SESSION['user']['user_id']
        ];

        $contest = new Contest();
        $contestProblem = new ContestProblem();

        $contest->createContest($contestInfo);
        $contestLastId = $contest->pdo->lastInsertId();

        $contestProblem->createContestProblem($selectedProblems, $contestLastId);

        header("Location: /teacher/manage-contests");
        exit;
    }
    public function handleContestsScore($contestId)
    {

        date_default_timezone_set('Asia/Manila');
        $currentTime = new DateTime();

        $contest = (new Contest())->getContestById($contestId);
        $endTime = new DateTime($contest[0]['end_time']);



        $isFinished = $currentTime > $endTime;

        $_SESSION['isFinished'] = $isFinished ? true : false;

        $studentId = $_SESSION['user']['user_id'];
        $submissions = (new Submission())->getAllWithCondition("contest_id = $contestId AND student_id = $studentId");

        $totalProblems = (new ContestProblem())->CountById($contestId, 'contest_id');

        $totalScore = 0;
        foreach ($submissions as $sub) {
            $totalScore += $sub['score'];
        }

        $averageScore = $totalProblems > 0 ? $totalScore / $totalProblems : 0;

        $leaderboard = new Leaderboard();
        (new Participants())->update($studentId, ['score' => $averageScore], 'user_id');
        $leaderboardExists = $leaderboard->getAllWithCondition("contest_id = $contestId AND user_id = $studentId");

        if ($leaderboardExists) {
            $leaderboard->update(
                $leaderboardExists[0]['id'],
                ['total_average_score' => $averageScore],
                'id'
            );
        } else {
            $leaderboard->insert(
                ['contest_id' => $contestId, 'user_id' => $studentId],
                ['total_average_score' => $averageScore]
            );
        }
        if ($isFinished) {
            $contestRank = $leaderboard->getRank($studentId, $contestId);
        }

        $this->viewAsStudent('student/FinishedContest', [
            'averageScore' => $averageScore,
            'contestId' => $contestId,
            'isFinished' => $isFinished,
            'rank' => $contestRank ?? 0,
        ]);
    }

    public function handleDeleteContest($id)
    {

        (new Participants())->deleteByContestId($id);


        (new ContestProblem())->deleteProblemByContestID($id);
        (new Participants())->deleteByContestId($id);
        (new Submission())->delete($id, 'contest_id');
        $folderPath = BASE_PATH . 'app/contest-submission/contest_' . $id;

        $this->deleteSubmissionFolder($id, $folderPath);

        (new Contest())->deleteContest($id);

        header("Location: /teacher/manage-contests");
        exit;
    }

    protected function deleteSubmissionFolder($contest_id, $folderPath)
    {
        if (!is_dir($folderPath)) return;

        $items = scandir($folderPath);
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') continue;

            $filePath = $folderPath . DIRECTORY_SEPARATOR . $item;

            if (is_dir($filePath)) {
                $this->deleteSubmissionFolder($contest_id, $filePath); // Recursively delete subdirectory
            } else {
                unlink($filePath); // Delete file
            }
        }

        rmdir($folderPath); // Delete the now-empty directory

    }

    public function viewUpdateContest($id)
    {
        $contest = (new Contest())->getContestById($id);
        $contest_problems = (new ContestProblem())->getAllProblemById($id);
        $allProblems = (new Problem())->getAllProblemsByTeacher($_SESSION['user']['user_id']);
        $problems = [];
        foreach ($contest_problems as $contest_problem) {
            $problems[] = (new Problem())->getAllProblemById($contest_problem['problem_id']);
        }
        $this->viewAsTeacher('teacher/CreateContest', [
            'contest' => $contest,
            'allProblems' => $allProblems,
            'problems' => $problems,
            'contest_problems' =>  $contest_problems
        ]);
    }

    public function handleUpdateContest($id)
    {
        $selectedProblems = $_POST['selectedProblems'];

        $contestInfo = [
            'name' => $_POST['contest-name'],
            'is_team_based' => ($_POST['contest-type'] === 'solo' ? false : true),
            'start_time' => $_POST['start_time'],
            'end_time' => $_POST['end_time'],
            'teacher_id' => $_SESSION['user']['user_id']
        ];

        $contest = (new Contest())->update($id, $contestInfo, 'id');
        $contestProblem = new ContestProblem();
        $contestProblem->deleteAllById($id);
        $contestProblem->createContestProblem($selectedProblems, $id);

        header("Location: /teacher/manage-contests");
        exit;
    }
    public function viewParticipants($id)
    {

        $contest = (new Contest())->getContestById($id);
        $participants = (new Participants())->getAllParticipantsWithRanks($id);
        $type = $contest[0]['is_team_based'] === 0 ? "SOLO" : "TEAM";

        $user_ids = array_column($participants, 'user_id');
        $team_ids = array_column($participants, 'team_id');

        $users = (new user())->getAllByColumnIn('user_id', $user_ids);
        $teams = (new user())->getAllByColumnIn('user_id', $team_ids);
        $ranks = (new Participants())->getRank($_SESSION['user']['user_id'], $id);

        $combinedParticipants = [];
        foreach ($participants as $p) {
            $isTeam = $p['team_id'] !== null;
            $entityId = $isTeam ? $p['team_id'] : $p['user_id'];
            $entityList = $isTeam ? $teams : $users;

            $entityData = array_filter($entityList, fn($e) => $e['user_id'] == $entityId);
            $entityData = array_values($entityData);
            $name = $entityData[0]['username'] ?? 'Unknown';

            $combinedParticipants[] = [
                'id' => $p['id'],
                'user_id' => $p['user_id'],
                'name' => $name,
                'is_team' => $isTeam,
                'status' => $p['status'],
                'score' => $p['score'] ?? 0,
                'rank' => $p['rank'] ?? null,
            ];
        }

        $_SESSION['contest_id'] = $contest[0]['id'];

        $this->viewAsTeacher('teacher/ContestParticipants', [
            'participants' => $combinedParticipants,
            'contest' => $contest,
        ]);
    }
    public function handleAcceptParticipant($id)
    {
        $participant = (new Participants())->update($id, ['status' => 'accepted'], 'user_id');
        header('Location: /teacher/manage-contests');
    }
    public function handleRejectParticipant($id)
    {
        $participant = (new Participants())->update($id, ['status' => 'rejected'], 'user_id');
        header('Location: /teacher/manage-contests');
    }
    public function handleAddTeamParticipant($team_id)
    {
        $participant = (new Participants())->addParticipantTeam($_SESSION['contenst_id'], $team_id);
    }
    public function handleAddParticipant($id)
    {
        $participant = (new Participants())->addParticipant($id, $_SESSION['user']['user_id']);

        header("Location: /teacher/manage-contests");
        exit;
    }
    public function handleQuitParticipant($id)
    {
        $participant = (new Participants())->deleteContestParticipants($_SESSION['user']['user_id'], $id);

        if (!$participant) {
            echo "Failed To Quit";
        }
        header("Location: /teacher/manage-contests");
        exit;
    }
}
