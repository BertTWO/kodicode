<?php
require_once(BASE_PATH . 'core/Model.php');

class Submission extends Model
{
    protected $tablename = 'submissions';

    public function nonContestCreateSubmission($submission_data)
    {
        return $this->insert($submission_data);
    }
    public function getAllSolvedProblems($id){
        return $this->getAllWithCondition(" student_id = $id AND contest_id IS NULL");
    }
}
