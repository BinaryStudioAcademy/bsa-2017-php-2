<?php

namespace BinaryStudioAcademyTests\Tools;

class Migrator
{
    const SCHEMA_FILE = __DIR__ . '/../../src/schema.sql';

    private $connection;

    public function __construct(\PDO $pdo)
    {
        $this->connection = $pdo;
    }

    private function getSchemaSql(): string
    {
        return file_get_contents(self::SCHEMA_FILE);
    }

    public function up()
    {
        $query = $this->getSchemaSql();
        $this->connection->prepare($query)->execute();
    }

    public function down()
    {
        $this->connection->prepare('DROP TABLE bookings')->execute();
        $this->connection->prepare('DROP TABLE tickets')->execute();
        $this->connection->prepare('DROP TABLE users')->execute();
    }
}
