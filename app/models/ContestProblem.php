<?php
require_once(BASE_PATH . 'core/Model.php');

class ContestProblem extends Model
{
    protected $tablename = 'contest_problems';

    public function createContestProblem($data,$contest_id)
    {
        $decodedData = json_decode($data[0],true);
        
        foreach($decodedData as $problemId){
            
           $this->insert([
                'contest_id'=>$contest_id,
                'problem_id'=>$problemId,
            ]);
        }
    
    }
    public function deleteProblemByContestID($contest_id){
        return $this->delete($contest_id,'contest_id');
    }
    public function getAllProblemById($id)
    {
        return $this->getAllByColumn('contest_id',$id);
    }
    public function deleteAllById($id){
        return $this->delete($id,'contest_id');
    }
}
