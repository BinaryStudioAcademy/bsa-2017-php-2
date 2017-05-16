<?php

namespace BinaryStudioAcademyTests\Tools;

class ConnectionFactory
{
    const DEFAULT_USERNAME = 'homestead';
    const DEFAULT_PASSWORD = 'secret';
    const DEFAULT_HOST = 'localhost';
    const DEFAULT_DATABASE = 'bsa_php_2017';

    public function make(): \PDO
    {
        return new \PDO(
            sprintf(
                'mysql:host=%s;dbname=%s',
                getenv('DB_HOST') ?? self::DEFAULT_HOST,
                getenv('DB_DATABASE') ?? self::DEFAULT_DATABASE
            ),
            getenv('DB_USERNAME') ?? self::DEFAULT_USERNAME,
            getenv('DB_PASSWORD') ?? self::DEFAULT_PASSWORD,
            [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ]
        );
    }
}
