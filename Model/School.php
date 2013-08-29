<?php

class Model_School {

    public function detailed_list()
    {
        $pdo = Db::getPdo();
        $sql = "SELECT *, count(a.id) as admins, count(t.id) as teachers, count(p.id) as students
        FROM schools s
        LEFT JOIN users a ON (s.id = a.school AND a.status = :adm)
        LEFT JOIN users t ON (s.id = t.school AND t.status = :tcr)
        LEFT JOIN users p ON (s.id = p.school AND p.status = :std)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':adm', Model_User::SCHOOL_ADMIN);
        $stmt->bindValue(':tcr', Model_User::TEACHER);
        $stmt->bindValue(':std', Model_User::STUDENT);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    public function add($name)
    {
        $pdo = Db::getPdo();
        $stmt = $pdo->prepare("INSERT INTO schools (title) VALUES(:name)");
        $stmt -> bindParam(':name', $name);
        $exec = $stmt->execute();
    }

    public static function getCurrent()
    {
        return $_SESSION['user']->school;
    }
}