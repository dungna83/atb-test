<?php

namespace Api\Model;

use Api\Core\Database;

class UserModel
{
    const TABLE_NAME = 'user';

    public static function all()
    {
        //TODO: paginate results
        $sql = "SELECT * FROM `" . self::TABLE_NAME . "` ORDER BY `created` DESC";
        $q = Database::$pdo->prepare($sql);
        $q->execute();
        $row = $q->fetchAll();

        return $row;
    }

    public static function findByEmail($email)
    {
        $sql = "SELECT * FROM `" . self::TABLE_NAME . "` WHERE `email` = ?";
        $q = Database::$pdo->prepare($sql);
        $q->execute(array($email));
        $row = $q->fetch();

        return $row;
    }

    public static function insert($data)
    {
        try {
            $sql_insert = "INSERT INTO `" . self::TABLE_NAME . "` (`email`, `password`, `full_name`, `tel`, `address`) VALUES (?,?,?,?,?)";
            $q = Database::$pdo->prepare($sql_insert);

            // bind the values
            $q->bindValue(1, $data['email']);
            $q->bindValue(2, $data['password']);
            $q->bindValue(3, $data['full_name']);
            $q->bindValue(4, $data['tel']);
            $q->bindValue(5, $data['address']);
            $q->execute();

            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public static function update($data)
    {
        try {
            $sql_update = "UPDATE `" . self::TABLE_NAME . "` SET `full_name` = ?, `tel` = ?, `address` = ? WHERE `email` = ?";
            $q = Database::$pdo->prepare($sql_update);
            $q->bindValue(1, $data['full_name']);
            $q->bindValue(2, $data['tel']);
            $q->bindValue(3, $data['address']);
            $q->bindValue(4, $data['email']);
            $q->execute();

            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public static function updatePassword($data)
    {
        try {
            $sql_update = "UPDATE `" . self::TABLE_NAME . "` SET `password` = ? WHERE `email` = ?";
            $q = Database::$pdo->prepare($sql_update);
            $q->bindValue(1, $data['password']);
            $q->bindValue(2, $data['email']);
            $q->execute();

            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

}

