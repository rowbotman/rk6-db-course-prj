TRUNCATE TABLE airport_rating;
DROP TABLE IF EXISTS airport_rating;
CREATE TABLE IF NOT EXISTS airport_rating
(
    hash_id           VARCHAR(64)         NOT NULL CHECK ( hash_id <> '' ) PRIMARY KEY,
    hash_group        VARCHAR(64)         NOT NULL CHECK ( hash_group <> '' ),
    airport           VARCHAR(256)        CHECK ( airport <> '' ),
    start_date        TIMESTAMP           NOT NULL DEFAULT current_timestamp,
    end_date          TIMESTAMP           NOT NULL DEFAULT current_timestamp,
    tickets_out       INT                 NOT NULL DEFAULT 0,
    tickets_in        INT                 NOT NULL DEFAULT 0
) ENGINE=InnoDB;


-- процедура получения данных: сколько продано билетов конкретного класса, процент от общего колличества,
-- название аэропорта, сколько бонусных миль по отправке, по прибытию
DROP PROCEDURE IF EXISTS  get_airport_rating;
DELIMITER $$ ;
CREATE PROCEDURE get_airport_rating
(
    IN start_date_in TIMESTAMP,
    IN end_date_in TIMESTAMP
)
BEGIN
    DECLARE airport_var    VARCHAR(256)  DEFAULT '';
    DECLARE tickets_var    INT           DEFAULT 0 ;
    DECLARE done           INT           DEFAULT 0 ;
    DECLARE hash_id_var    VARCHAR(64)   DEFAULT '';
    DECLARE hash_group_var VARCHAR(64)   DEFAULT '';

    DECLARE cur1 CURSOR FOR
        SELECT DISTINCT SHA(CONCAT(start_date_in, end_date_in, f.dep_airport)),
                        SHA(CONCAT(start_date_in, end_date_in)),f.dep_airport,
                        COUNT(t.uid)
        FROM flight f JOIN ticket t ON (t.flight_id = f.uid)
        WHERE f.dep_date BETWEEN start_date_in AND end_date_in
        GROUP BY f.dep_airport;
    DECLARE cur2 CURSOR FOR
        SELECT DISTINCT SHA(CONCAT(start_date_in, end_date_in, f.arr_airport)),
                        SHA(CONCAT(start_date_in, end_date_in)),f.arr_airport,
                        COUNT(t.uid)
        FROM flight f JOIN ticket t ON (t.flight_id = f.uid)
        WHERE f.dep_date BETWEEN start_date_in AND end_date_in
        GROUP BY f.arr_airport;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

    OPEN cur1;
    WHILE done = 0 DO
        FETCH cur1 INTO hash_id_var, hash_group_var, airport_var, tickets_var;
        INSERT INTO airport_rating (hash_id, hash_group, start_date, end_date, airport, tickets_out)
            VALUES (hash_id_var, hash_group_var, start_date_in, end_date_in, airport_var, tickets_var)
            ON DUPLICATE KEY UPDATE tickets_out = tickets_var;
    END WHILE;

    SET done = 0;
    OPEN cur2;
    WHILE done = 0 DO
        FETCH cur2 INTO hash_id_var, hash_group_var, airport_var, tickets_var;
        INSERT INTO airport_rating (hash_id, hash_group, start_date, end_date, airport, tickets_in)
            VALUES (hash_id_var, hash_group_var, start_date_in, end_date_in, airport_var, tickets_var)
            ON DUPLICATE KEY UPDATE tickets_in = tickets_var;
    END WHILE;
END $$
DELIMITER ; $$
