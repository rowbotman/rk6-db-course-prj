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
}
