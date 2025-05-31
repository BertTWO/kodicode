<?php
require_once(BASE_PATH . 'core/Model.php');
class Participants extends Model
{
    protected $tablename = 'contest_participants';

    public function addParticipant($contest_id, $student_id)
    {
        return $this->insert([
            'contest_id' => $contest_id,
            'user_id' => $student_id,
            'status' => 'pending'
        ]);
    }
    public function deleteByContestId($id)
    {
        return $this->delete($id, 'contest_id');
    }
    public function deleteContestParticipants($user_id, $contest_id)
    {
        $toDeleteData = $this->getAllWithCondition("user_id = $user_id AND contest_id = $contest_id");
        return $this->delete($toDeleteData[0]['id'], 'id');
    }
    public function addParticipantTeam($contest_id, $team_id)
    {
        return $this->insert([
            'contest_id' => $contest_id,
            'team_id' => $team_id,
            'status' => 'pending'
        ]);
    }
    public function getStatus() {}
    public function joinedContests(int $user_id, array $contests): array
    {
        if (empty($contests)) {
            return [];
        }

        try {
            $contestIds = array_column($contests, 'id');

            $placeholders = rtrim(str_repeat('?,', count($contestIds)), ',');
            $sql = sprintf(
                "SELECT * FROM %s WHERE user_id = ? AND contest_id IN (%s)",
                $this->tablename,
                $placeholders
            );

            $params = array_merge([$user_id], $contestIds);

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException("Database error while fetching joined contests: " . $e->getMessage());
        }
    }
    public function getRank($user_id, $contest_id)
    {
        $sql = "
        SELECT user_id, score, rank FROM (
            SELECT user_id, score,
                RANK() OVER (PARTITION BY contest_id ORDER BY score DESC) AS rank
            FROM {$this->tablename}
            WHERE contest_id = ?
        ) ranked
        WHERE user_id = ?
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$contest_id, $user_id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function countAllParticipants()
    {
        return $this->Count();
    }
    public function getAllParticipantsWithRanks($contest_id)
    {
        $sql = "
        SELECT *, 
            RANK() OVER (PARTITION BY contest_id ORDER BY score DESC) AS rank 
        FROM {$this->tablename}
        WHERE contest_id = ?
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$contest_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function acceptParticipants($id)
    {
        return $this->update($id, ['status' => 'accepted'], 'id');
    }
    public function rejectParticipants($id)
    {
        return $this->update($id, ['status' => 'rejected'], 'id');
    }
}
