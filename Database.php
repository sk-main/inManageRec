<?php

class Database
{
    private PDO $pdo;

    public function __construct(
        string $host,
        string $dbName,
        string $user,
        string $password
    ) {
        $dsn = "mysql:host=$host;dbname=$dbName;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        $this->pdo = new PDO($dsn, $user, $password, $options);
    }

    public function select(string $sql, array $params = []): array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function insert(string $table, array $data): int
    {
        $cols   = implode(', ', array_keys($data));
        $places = implode(', ', array_fill(0, count($data), '?'));
        $sql    = "INSERT INTO $table ($cols) VALUES ($places)";
        $stmt   = $this->pdo->prepare($sql);
        $stmt->execute(array_values($data));
        return (int) $this->pdo->lastInsertId();
    }

    public function update(string $table, array $data, string $where, array $whereParams = []): int
    {
        $set  = implode(', ', array_map(fn($col) => "$col = ?", array_keys($data)));
        $sql  = "UPDATE $table SET $set WHERE $where";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([...array_values($data), ...$whereParams]);
        return $stmt->rowCount();
    }

    public function delete(string $table, string $where, array $whereParams = []): int
    {
        $sql  = "DELETE FROM $table WHERE $where";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($whereParams);
        return $stmt->rowCount();
    }
}