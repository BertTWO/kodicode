<?php

class Model
{
    protected $pdo;
    protected $tablename = '';
    
    public function __construct()
    {
        $config  = require_once(BASE_PATH.'config/dbconfig.php');

        $database = new Database();

        $this->pdo = $database->db_connect(
            "mysql:host={$config['host']};dbname={$config['dbname']}", 
            $config['user'], 
            $config['pass']
        );
    }
    public function getAll(){

        $stmt = $this->pdo->query("SELECT * FROM  $this->tablename");
        $models = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $models;
    }

    public function getById($id){

        $stmt = $this->pdo->prepare("SELECT * FROM $this->tablename WHERE user_id = ?");
        $stmt->bindValue(1,$id);
        $stmt->execute();
        $model = $stmt->fetch(PDO::FETCH_OBJ);

        return $model;
    }

    public function insert($data){
        $columns = implode(',',array_keys($data));
        $values = implode(',',array_fill(0,count($data), "?"));

        $i = 1;

        $stmt = $this->pdo->prepare("INSERT INTO $this->tablename($columns) VALUES($values)");

        foreach($data as $key => $value){
            $stmt->bindValue($i,$value);
            $i++;
        }

        $stmt->execute();
    }
}
