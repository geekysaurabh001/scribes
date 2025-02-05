<?php

namespace Core;

use PDO;
use PDOException;
use Exception;

class Database
{
    private $connection;
    private $stmt;
    private $queryType;

    public function __construct(string $host, string $port, string $dbname, string $user, string $password)
    {
        try {
            // $dsn = "mysql:unix_socket=$unixSocket;dbname=$dbname;charset=utf8mb4";
            $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $this->connection = new PDO($dsn, $user, $password, $options);
        } catch (\PDOException $e) {
            echo (int)$e->getCode() . " : " . $e->getMessage();
            die();
        }
    }

    public function query(string $query,)
    {
        // dd($query);
        $this->stmt = $this->connection->prepare($query);
        // Determine query type based on the first word in the query
        $this->queryType = strtolower(strtok(trim($query), ' '));
        // dd($this->stmt);
        return $this;
    }

    public function execute($params = [])
    {
        try {
            if ($this->isInsertQuery()) {
                $params = $this->handleInsertParams($params);
            } elseif ($this->isUpdateQuery() || $this->isDeleteQuery()) {
                if (!isset($params[':publicId']) && !isset($params['publicId'])) {
                    throw new Exception("Missing ':publicId' or 'publicId' parameter for the operation.");
                }
                if (!isset($params[':table']) && !isset($params['table'])) {
                    throw new Exception("Missing ':table' or 'table' parameter for the operation.");
                }
                if (isset($params[':publicId']) && isset($params[':table'])) {
                    $this->validatePublicIdExists($params[':publicId'], $params[':table']);
                    unset($params[":table"]);
                } else {
                    $this->validatePublicIdExists($params['publicId'], $params['table']);
                    unset($params[":table"]);
                }
            }
            // if ($this->queryType === 'insert') {
            //     print_r($this->stmt);
            //     print_r($params);
            //     dd($this->stmt->execute($params));
            // }
            $this->stmt->execute($params);
        } catch (PDOException $e) {
            // Log the exception (optional)
            error_log("Error executing query: " . $e->getMessage() . " | file: " . __FILE__ . " | line: 64");

            // // For SELECT queries, return a default empty array or an error message
            if ($this->isSelectQuery()) {
                return;
            }

            // Re-throw other exceptions or return an error message for other queries
            return ['error' => $e->getMessage()];
        }
        return $this;
    }

    private function isInsertQuery(): bool
    {
        return $this->queryType === 'insert';
    }

    private function isUpdateQuery(): bool
    {
        return $this->queryType === 'update';
    }

    private function isDeleteQuery(): bool
    {
        return $this->queryType === 'delete';
    }

    private function isSelectQuery(): bool
    {
        return $this->queryType === 'select';
    }

    private function validatePublicIdExists(string $publicId, string $table, string $column = 'public_id'): void
    {
        if (!$this->isUniquePublicId($publicId, $table, $column)) {
            return; // Public ID exists, validation passed
        }

        throw new Exception("Public ID '$publicId' does not exist in table '$table'.");
    }

    public function handleInsertParams(array $params): array
    {
        if (!isset($params[":publicId"])) {
            $params[":publicId"] = NanoIdGenerator::generateUniqueId(function ($id) {
                return $this->isUniquePublicId($id);
            });
        }
        return $params;
    }

    public function isUniquePublicId(string $id, string $table = 'users', string $column = 'public_id'): bool
    {
        // Use placeholders for table and column names to prevent SQL injection
        $query = sprintf(
            "SELECT COUNT(*) FROM %s WHERE %s = :publicId",
            preg_replace('/[^a-zA-Z0-9_]/', '', $table),
            preg_replace('/[^a-zA-Z0-9_]/', '', $column)
        );
        // dd($id);
        // dd($query);
        // var_dump("saurabh:::", $query);
        $stmt = $this->connection->prepare($query);
        $stmt->execute([':publicId' => $id]);
        return $stmt->fetchColumn() == 0;
    }

    public function fetchAll()
    {
        return $this->stmt->fetchAll();
    }

    public function fetch()
    {
        return $this->stmt->fetch();
    }

    public function fetchOrAbort()
    {
        $result = $this->fetch();
        if (!$result) {
            abort();
        }

        return $result;
    }
}
