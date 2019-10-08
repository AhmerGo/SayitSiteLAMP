/*
CREATE DATABASE sayit_db;
CREATE USER 'sayit_user'@'localhost' IDENTIFIED BY 'thepassword';
GRANT ALL PRIVILEGES ON sayit_db TO 'sayit_user'@'localhost';
GRANT ALL PRIVILEGES ON sayit_db.* TO 'sayit_user'@'localhost';
FLUSH PRIVILEGES;
*/

CREATE TABLE messages (
	message_id INTEGER NOT NULL AUTO_INCREMENT,
	ts         TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	topic      VARCHAR(100) DEFAULT '',
	message    VARCHAR(500) DEFAULT '',
	PRIMARY KEY(message_id)
) ENGINE=InnoDB;

SELECT CONVERT_TZ(ts,@@session.time_zone, '-05:00') AS ts, topic, message FROM messages
	ORDER BY ts DESC LIMIT 10;

SELECT topic, COUNT(topic) FROM messages GROUP BY topic ORDER BY COUNT(topic) DESC, topic;
