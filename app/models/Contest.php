<?php
require_once (BASE_PATH.'core/Model.php');

class Contest extends Model{
    protected $tablename = 'contests';

    public function createContest($data)
    {
        return $this->insert($data);
    }
    public function getAllContest($id)
    {
        $myContest = $this->getAllByColumn('teacher_id',$id);
        $allContest = $this->getAllWithCondition("teacher_id != $id");
        return[
            'myContest'=>$myContest,
            'allContest'=>$allContest
        ];
        
    }
    public function countAllContests()
    {
        return $this->Count();
    }
    public function getContestById($id){
        return $this->getAllByColumn('id',$id);
    }
    public function deleteContest($id){
        return $this->delete($id,'id');
    }
}