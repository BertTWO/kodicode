<?php

class Model
{
    public $pdo;
    protected $tablename = '';

    public function __construct()
    {
        $config  = require(BASE_PATH . 'config/dbconfig.php');

        $database = new Database();

        $this->pdo = $database->db_connect(
            "mysql:host={$config['host']};dbname={$config['dbname']}",
            $config['user'],
            $config['pass']
        );
    }
    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM  $this->tablename");
        $models = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $models;
    }
    public function Count()
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM $this->tablename");
        return (int) $stmt->fetchColumn();
    }
    public function CountById($id,$columnName)
    {
         $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM $this->tablename WHERE $columnName = ?");
         $stmt->bindValue(1, $id);
         $stmt->execute();
         return (int) $stmt->fetchColumn();
    }
    public function getAllWithCondition($condition)
    {
        $stmt = $this->pdo->query("SELECT * FROM  $this->tablename WHERE $condition");
        $models = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $models;
    }
    public function getAllByColumn($column, $value)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->tablename WHERE $column = ?");
        $stmt->bindValue(1, $value);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllByColumnIn($column, array $values)
    {
        if (empty($values)) {
            return [];
        }
        $placeholders = implode(',', array_fill(0, count($values), '?'));
        $stmt = $this->pdo->prepare("SELECT * FROM $this->tablename WHERE $column IN ($placeholders)");
        foreach ($values as $index => $value) {
            // Bind values starting at 1
            $stmt->bindValue($index + 1, $value);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->tablename WHERE user_id = ?");
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $model = $stmt->fetch(PDO::FETCH_ASSOC);

        return $model;
    }

    public function insert($data)
    {
        $columns = implode(',', array_keys($data));
        $values = implode(',', array_fill(0, count($data), "?"));

        $i = 1;

        $stmt = $this->pdo->prepare("INSERT INTO $this->tablename($columns) VALUES($values)");

        foreach ($data as $key => $value) {
            $stmt->bindValue($i, $value);
            $i++;
        }

        $stmt->execute();
    }

    public function update($id, $data, $columnName = 'user_id')
    {
        $columns = array_keys($data);
        $setClause = implode(', ', array_map(fn($col) => "$col = ?", $columns));

        $stmt = $this->pdo->prepare("UPDATE $this->tablename SET $setClause WHERE $columnName = ?");

        $i = 1;
        foreach ($data as $value) {
            $stmt->bindValue($i++, $value);
        }

        $stmt->bindValue($i, $id);

        return $stmt->execute();
    }
    public function delete($id, $column = 'user_id')
    {
        $stmt = $this->pdo->prepare("DELETE FROM $this->tablename WHERE $column = ?");
        $stmt->bindValue(1, $id);
        return $stmt->execute();
    }
      private function performJoin(
        string $foreignTable,
        string $foreignKey,
        string $primaryKey,
        string $columns,
        string $joinType,
        ?string $where,
        array $params
    ): array {
        $sql = "SELECT $columns
                FROM {$this->tablename}
                $joinType JOIN $foreignTable
                ON {$this->tablename}.$foreignKey = $foreignTable.$primaryKey";

        if ($where) {
            $sql .= " WHERE $where";
        }

        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $i => $param) {
            $stmt->bindValue($i + 1, $param);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function innerJoin(
        string $foreignTable,
        string $foreignKey,
        string $primaryKey = 'id',
        string $columns = '*',
        ?string $where = null,
        array $params = []
    ): array {
        return $this->performJoin($foreignTable, $foreignKey, $primaryKey, $columns, 'INNER', $where, $params);
    }

    public function leftJoin(
        string $foreignTable,
        string $foreignKey,
        string $primaryKey = 'id',
        string $columns = '*',
        ?string $where = null,
        array $params = []
    ): array {
        return $this->performJoin($foreignTable, $foreignKey, $primaryKey, $columns, 'LEFT', $where, $params);
    }

    public function rightJoin(
        string $foreignTable,
        string $foreignKey,
        string $primaryKey = 'id',
        string $columns = '*',
        ?string $where = null,
        array $params = []
    ): array {
        return $this->performJoin($foreignTable, $foreignKey, $primaryKey, $columns, 'RIGHT', $where, $params);
    }
}

