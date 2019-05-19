CREATE DATABASE IF NOT EXISTS bonus_program;
DROP TABLE IF EXISTS flight;
DROP TABLE IF EXISTS ticket;
DROP TABLE IF EXISTS detail;
DROP TABLE IF EXISTS profile;


DROP ROLE IF EXISTS bonus;
CREATE USER'bonus'@'localhost' IDENTIFIED BY 'bonus';

USE bonus_program;

CREATE TABLE IF NOT EXISTS profile (
   uid       INT                           NOT NULL AUTO_INCREMENT PRIMARY KEY,
   firstName VARCHAR(32)                   NOT NULL,
   lastName  VARCHAR(32)                   NOT NULL,
   votes     INT                           NOT NULL DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS flight
(
    uid         INT                         NOT NULL AUTO_INCREMENT PRIMARY KEY,
    dep_airport VARCHAR(128)                NOT NULL CHECK ( dep_airport <> '' ),
    arr_airport VARCHAR(256)                NOT NULL CHECK ( arr_airport <> '' ),
    dep_date    TIMESTAMP                   NOT NULL DEFAULT current_timestamp
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS ticket
(
    uid         INT                         NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id     INT                         NOT NULL,
    flight_id   INT                         NOT NULL,
#     dep_airport VARCHAR(128)                NOT NULL CHECK ( dep_airport <> '' ),
#     departure   TIMESTAMP                   NOT NULL DEFAULT current_timestamp,
    class       INT                         NOT NULL DEFAULT 4,
    price       INT                         NOT NULL DEFAULT 0,

    FOREIGN KEY (user_id)   REFERENCES profile (uid),
    FOREIGN KEY (flight_id) REFERENCES flight  (uid)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS detail
(
    profile_id  INT                         NOT NULL,
    ticket_id   INT                         NOT NULL,
    cur_value   BIGINT                      NOT NULL DEFAULT 0,
    bonus_date  TIMESTAMP                   NOT NULL DEFAULT current_timestamp,
    FOREIGN KEY (profile_id) REFERENCES profile (uid),
    FOREIGN KEY (ticket_id)  REFERENCES ticket  (uid)
) ENGINE=InnoDB;



GRANT ALL   PRIVILEGES ON bonus_program TO 'root'@'localhost';
GRANT ALL   PRIVILEGES ON bonus_program TO 'bonus'@'localhost';
FLUSH PRIVILEGES;
