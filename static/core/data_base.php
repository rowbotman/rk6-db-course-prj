<?php
class DataBase {
    public static $dbh = '';
    private static $dsn = 'mysql:host=localhost;dbname=bonus_program';
    private static $user = 'bonus';
    private static $password = 'bonus';

    public static function connection() {
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

    public static function query($query) {
        $stmt = self::connection()->query($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function paramQuery($query, $params = array()) {
        $stmt = self::connection()->prepare($query);
        $stmt->execute((array) $params);
        return $stmt->fetchAll();
    }
    public static function getRow($query, $params = array()) {
        $stmt = self::connection()->prepare($query);
        $stmt->execute((array) $params);
        return $stmt->fetch(PDO::FETCH_LAZY);
    }

    public static function paramQueryWithBind($query, $params) {
        $stmt = self::connection()->prepare($query);
//        foreach ($params as $item) {
//            $stmt->bindParam($item[0], $item[1], $item[2], $item[3]);
//        }
        $stmt->bindParam($params[0], $params[1], $params[2]);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
