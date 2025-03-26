<?php

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Udf.php';

class Graduates extends Database
{
    public string $first_name = '';
    public string $middle_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $student_number = '';
    public string $course = '';
    public string $graduation_year = '';
    public string $permanent_address = '';
    public string $mobile_number = '';
    public string $employment = '';
    public string $civil_status = '';
    public string $gender = '';
    public string $regions = '';
    public string $provinces = '';
    public string $municipalities = '';
    public string $barangays = '';

    function __construct()
    {
        parent::__construct();
        $this->fields = [
            'first_name', 'middle_name', 'last_name', 'email', 'student_number',
            'course', 'graduation_year', 'permanent_address', 'mobile_number',
            'employment', 'civil_status', 'gender', 'regions', 'provinces',
            'municipalities', 'barangays'
        ];
        $this->tableName = 'graduates';
    }

    function list()
    {
        $this->sql = "SELECT 
            g.id, g.first_name, g.middle_name, g.last_name,
            g.student_number, g.course, g.graduation_year,
            g.permanent_address,
            eb.degree, eb.college,
            pe.name_of_exam, pe.date_taken, pe.rating,
            es.company_name
        FROM graduates g
        LEFT JOIN educational_background eb ON g.id = eb.graduate_id
        LEFT JOIN professional_exams pe ON g.id = pe.graduate_id
        LEFT JOIN employment_survey es ON g.id = es.graduate_id";
        return $this->fetchAll();
    }

    function read()
    {
        $fields = implode(",", Udf::removeKeysArray($this->fields, ['modifiedId', 'createdId']));
        $this->sql = "SELECT id, $fields FROM " . $this->tableName . " WHERE id=" . $this->id;
        return $this->fetch();
    }

    public function save()
    {
        $fieldMap = array_map(fn ($field) => ":$field", $this->fields);
        $values = implode(",", $fieldMap);
        $fields = implode(",", $this->fields);

        $this->sql = "INSERT INTO " . $this->tableName . " ($fields) VALUES ($values)";
        $statement = $this->pdo->prepare($this->sql);

        foreach ($this->fields as $field) {
            if (property_exists($this, $field)) {
                $statement->bindValue(":$field", $this->{$field});
            }
        }
        try {
            $this->pdo->beginTransaction();
            $statement->execute();
            $this->lastInsertId = $this->pdo->lastInsertId();
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw new PDOException($e->getMessage(), (int)$e->getCode());
            return false;
        }
    }

    public function update()
    {
        $fieldsToUpdate = in_array('createdId', $this->fields) ? Udf::removeKeysArray($this->fields, ['createdId']) : $this->fields;
        $fields = array_map(fn ($field) => "$field=:$field", $fieldsToUpdate);

        $this->sql = "UPDATE " . $this->tableName . " SET " . implode(',', $fields) . $this->condition;

        $statement = $this->pdo->prepare($this->sql);

        foreach ($fieldsToUpdate as $field) {
            if (property_exists($this, $field)) {
                $statement->bindValue(":$field", $this->{$field});
            }
        }
        try {
            $this->pdo->beginTransaction();
            $statement->execute();
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw new PDOException($e->getMessage(), (int)$e->getCode());
            return false;
        }
    }

    public function delete()
    {
        $this->sql = "DELETE FROM " . $this->tableName . $this->condition;
        $statement = $this->pdo->prepare($this->sql);

        try {
            $this->pdo->beginTransaction();
            $statement->execute();
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw new PDOException($e->getMessage(), (int)$e->getCode());
            return false;
        }
    }
}
?>