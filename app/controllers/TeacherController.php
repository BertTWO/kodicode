<?php
require_once BASE_PATH . 'core/Controller.php';
require_once BASE_PATH . 'app/controllers/TeacherController.php';

class TeacherController extends StudentController
{

    public function dashboard()
    {
        $studentModel = new Student();
        $contestModel = new Contest();
        $problemModel = new Problem();
        $participantModel = new Participants();

        $profile = $studentModel->getProfileInfo($_SESSION['user']['user_id']);
        $profile = $this->normalizeProfileData($profile);

        $stats = [
            'total_contests' => $contestModel->countAllContests(),
            'total_problems' => $problemModel->countAllProblems(),
            'total_participants' => $participantModel->countAllParticipants(),
        ];

        $data = array_merge($profile, ['stats' => $stats]);

        // Load view with data
        $this->viewAsTeacher('teacher/Dashboard', $data);
    }

    public function viewProfile()
    {
        $this->redirectIfNotAuthenticated();
        $profile = (new Student())->getProfileInfo($_SESSION['user']['user_id']);
        $this->viewAsTeacher('components/profile', $this->normalizeProfileData($profile));
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
    public function viewManangeProblems()
    {
        $problems = (new Problem())->getAllProblemsByTeacher($_SESSION['user']['user_id']);
        $allProblems = (new Problem())->getAllPublicProblemsWithTeacher();

        $this->viewAsTeacher('teacher/ManageProblems', ['problems' => $problems,'allProblems' => $allProblems]);
    }
    public function viewContests()
    {
        $contests = (new Contest())->getAllContest($_SESSION['user']['user_id']);
        $this->viewAsTeacher('teacher/ManageContests', $contests);
    }
    public function viewCreateContest()
    {
        $problems = (new Problem())->getAllProblemsByTeacher($_SESSION['user']['user_id']);
        $this->viewAsTeacher('teacher/CreateContest', ['problems' => $problems]);
    }
}
