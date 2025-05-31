<?php
require_once(BASE_PATH . 'core/Model.php');

class Problem extends Model
{
    protected $tablename = 'problems';

    public function getAllProblems()
    {
        return $this->getAll();
    }
    public function getAllPublicProblems()
    {

        return $this->getAllWithCondition('is_public = 1');
    }
    public function getAllPublicProblemsWithTeacher()
    {
        $sql = "SELECT 
                p.id, p.slug, p.title, p.difficulty, p.is_public, p.created_at, p.updated_at, p.teacher_id,
                pr.profile_id, pr.firstname, pr.lastname, pr.bio, pr.profile_picture, pr.contact_no, pr.address
            FROM problems p
            LEFT JOIN profiles pr ON p.teacher_id = pr.user_id
            WHERE p.is_public = 1";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllProblemsByTeacher($id)
    {
        return $this->getAllByColumn('teacher_id', $id);
    }
    public function countAllProblems()
    {
        return $this->Count();
    }
    public function getAllProblemById($id)
    {
        return $this->getAllByColumn('id', $id);
    }
    public function getProblemBySlug($slug)
    {
        return $this->getAllByColumn('slug', $slug);
    }
    public function createProblem($data)
    {
        return $this->insert($data);
    }
    public function updateProblem($slug, $data)
    {
        return $this->update($slug, $data, 'slug');
    }
    public function deleteProblem($slug)
    {
        return $this->delete($slug, 'slug');
    }
}
