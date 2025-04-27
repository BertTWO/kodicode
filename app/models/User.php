<?php
require_once (BASE_PATH.'core/Model.php');

class user extends Model{
    protected $tablename = 'users';

    public function findByUsername($username)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->tablename} WHERE username = ?");
        $stmt->bindValue(1, $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }
    
    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->tablename} WHERE email = ?");
        $stmt->bindValue(1, $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }
    
}