

<?php

class Database
{
    private $pdo;
    public function db_connect($dsn, $db_user, $db_pw)
    {
        try {
 
            $this->pdo = new PDO($dsn, $db_user, $db_pw);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $this->pdo; 
        } catch (PDOException $e) {
         
            die("Connection failed: " . $e->getMessage());
        }
    }

}
