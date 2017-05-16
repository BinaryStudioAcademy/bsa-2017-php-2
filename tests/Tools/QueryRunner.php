<?php

namespace BinaryStudioAcademyTests\Tools;

class QueryRunner
{
    /**
     * @var \PDO
     */
    private $connection;

    public function __construct(\PDO $pdo)
    {
        $this->connection = $pdo;
    }

    public function run(string $query, $params = null, $mode = null)
    {
        $statement = $this->connection->prepare($query);
        $statement->execute($params);

        if ($params === null && $mode === null) {
            return;
        }

        return $statement->fetchAll($mode);
    }
}
