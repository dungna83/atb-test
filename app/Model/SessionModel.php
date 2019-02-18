<?php

namespace Api\Model;

use Api\Core\Database;

class SessionModel
{
    const TABLE_NAME = 'session';

    public static function getToken($email)
    {
        $sql = "SELECT * FROM `" . self::TABLE_NAME . "` WHERE `email` = ?";
        $q = Database::$pdo->prepare($sql);
        $q->execute(array($email));
        $row = $q->fetch();

        return $row;
    }

    public static function findSession($token)
    {
        $sql = "SELECT * FROM `" . self::TABLE_NAME . "` WHERE `token` = ?";
        $q = Database::$pdo->prepare($sql);
        $q->execute(array($token));

        $q->execute();
        $row = $q->fetch();

        return $row;
    }

    public static function insert($data)
    {
        try {
            $sql_insert = "INSERT INTO `" . self::TABLE_NAME . "` (`email`, `token`, `expire`) VALUES (?,?,?)";
            $q = Database::$pdo->prepare($sql_insert);

            // bind the values
            $q->bindValue(1, $data['email']);
            $q->bindValue(2, $data['token']);
            $q->bindValue(3, $data['expire']);
            $q->execute();

            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public static function update($data)
    {
        try {
            $sql_update = "UPDATE `" . self::TABLE_NAME . "` SET `token` = ?, `expire` = ? WHERE `email` = ?";
            $q = Database::$pdo->prepare($sql_update);
            $q->bindValue(1, $data['token']);
            $q->bindValue(2, $data['expire']);
            $q->bindValue(3, $data['email']);
            $q->execute();

            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public static function delete($email)
    {
        try
        {
            $sql = "DELETE FROM `".self::TABLE_NAME."` WHERE `email` = ?";
            $q = Database::$pdo->prepare($sql);
            $q->execute(array($email));
            return true;
        } catch(\PDOException $e){
            return false;
        }
    }

}