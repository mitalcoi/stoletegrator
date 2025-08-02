## структура

```sql
CREATE TABLE grade
(
    grade    INT NULL,
    min_mark INT NULL,
    max_mark INT NULL
);

CREATE TABLE students
(
    id    INT          NULL,
    name  VARCHAR(100) NULL,
    marks INT          NULL
);
```

# grade >= 8

```sql
SELECT CASE
           WHEN mark >= 8 THEN name
           ELSE 'low'
           END AS name,
       mark    AS grade,
       mark
FROM students
ORDER BY mark DESC,
         CASE
             WHEN mark >= 8 THEN name
             ELSE NULL
             END ASC,
         CASE
             WHEN mark < 8 THEN mark
             ELSE NULL
             END ASC;
```

## Оптимизация

1) добавим составной индекс: `CREATE INDEX idx_students_mark_name ON students(mark, name);` (или просто  `CREATE INDEX idx_students_mark ON students(mark);`)
2) поменяем `INT` на `TINYINT UNSIGNED`
