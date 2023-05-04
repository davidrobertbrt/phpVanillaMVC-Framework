CREATE DATABASE weather;

CREATE TABLE weather(
    id INT(11) NOT NULL AUTO_INCREMENT,
    date DATE NOT NULL,
    temperature INT(11) NOT NULL,
    CONSTRAINT weatherRecords_pk PRIMARY KEY(id)
);

INSERT INTO
    weather(
        date,temperature
    )
VALUES(
    '2023-5-4',17
);

INSERT INTO
    weather(
        date,temperature
    )
VALUES(
    '2023-5-5',21
);

INSERT INTO
    weather(
        date,temperature
    )
VALUES(
    '2023-5-6',21
);