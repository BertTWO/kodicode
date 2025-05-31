<?php
require_once (BASE_PATH.'core/Model.php');

class Student extends Model{
    protected $tablename = 'profiles';

    public function getProfileInfo($user_id)
    {
        return $this->getAllByColumn('user_id',$user_id);
    }
    
    public function save($id, $data)
    {
        $existing = $this->getById($id);
        if ($existing) {
            return $this->update($id, $data);
        } else {
            $data['user_id'] = $id;
            return $this->insert($data);
        }
    }
    
}