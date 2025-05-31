<?php
require_once(BASE_PATH . 'core/Model.php');

class Leaderboard extends Model
{
    protected $tablename = 'leaderboard';

    public function getAll()
    {
        return $this->getAll();
    }
    

    public function getRank($user_id, $contest_id)
    {
        $sql = "
            SELECT user_id, 
                   FIND_IN_SET(total_average_score, (
                       SELECT GROUP_CONCAT(total_average_score ORDER BY total_average_score DESC)
                       FROM {$this->tablename}
                       WHERE contest_id = ?
                   )) AS rank
            FROM {$this->tablename}
            WHERE user_id = ? AND contest_id = ?
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $contest_id);
        $stmt->bindValue(2, $user_id);
        $stmt->bindValue(3, $contest_id);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (int)$result['rank'] : null;
    }
}
