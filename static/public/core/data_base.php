<?php

class DataBase
{
    public static $dbh = '';
    private static $dsn = 'mysql:host=localhost;dbname=bonus_program';
    private static $user = 'bonus';
    private static $password = 'bonus';

    public static function connection()
    {
//        try { // не обрабатываю ошибку, поэтому нет смысла просто ее выводить
        // php и так ее выведет
        if (!self::$dbh) {
            self::$dbh = new PDO(self::$dsn, self::$user, self::$password, array(
                PDO::ATTR_PERSISTENT => true
            ));
        }
        return self::$dbh;
//        } catch (PDOException $e) {
//            print 'Error with db connection';
//        }
    }

    public static function query($query)
    {
        $stmt = self::connection()->query($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function paramQuery($query, $params = array())
    {
        $stmt = self::connection()->prepare($query);
        $stmt->execute((array)$params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getRow($query, $params = array())
    {
        $stmt = self::connection()->prepare($query);
        $stmt->execute((array)$params);
        return $stmt->fetch(PDO::FETCH_LAZY);
    }

    public static function paramQueryWithBind($query, $params)
    {
        $stmt = self::connection()->prepare($query);
        $stmt->bindParam($params[0], $params[1], $params[2]);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function procedureCall($query, $check_param)
    {
        $sql = 'SELECT @' . $check_param . ';';
        echo $sql;
        // TODO: исправить на переменные sql
        $stmt = self::connection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result[0] != NULL) {
            return ['Отчет уже существует', $result];
        }


        $stmt = self::connection()->prepare($query);
        $stmt->execute();
        $stmt->closeCursor();
        return ['Отчет успешно создан'];
    }

    public static function procedureCallWithParam($query, $check_query, $params)
    {
        // TODO: исправить на переменные sql
        $stmt = self::connection()->prepare($check_query);
        $stmt->execute();
        $result = $stmt->rowCount();
        $stmt->closeCursor();
        if ($result) {
            return 0;
        }

        $stmt = self::connection()->prepare($query);
        $stmt->execute($params);
        $stmt->closeCursor();
        $stmt = self::connection()->prepare($check_query);
        $stmt->execute();
        $result = $stmt->rowCount();
        $stmt->closeCursor();
        if ($result <= 0) {
            return -1;
        }
        return 1;
    }
}
