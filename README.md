1. composer install
2. Создайте файл переменных окружения с параметрами
* DB_HOST=localhost
* DB=
* DB_USER=
* DB_PASS=

Запрос схемы таблицы
```sql
CREATE TABLE random_records
(
    id bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
    text varchar(255),
    create_date timestamp DEFAULT now()
);
```

Создаем вспомогательную процедуру для заполнения тест данными
```sql

CREATE PROCEDURE prepare_million_records()
  BEGIN
    DECLARE i INT DEFAULT 0;

    WHILE i < 1000000 DO
      INSERT INTO random_records (text) VALUES (MD5(RAND()));
      SET i = i + 1;
    END WHILE;
END;
```

Вызов процедуры
```sql
CALL prepare_date()
```

Примеры SQL даны для MariaDB (MySQL), 10.1.43-MariaDB