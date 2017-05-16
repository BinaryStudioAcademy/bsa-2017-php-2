<?php

namespace BinaryStudioAcademyTests;

use BinaryStudioAcademyTests\Tools\ConnectionFactory;
use BinaryStudioAcademyTests\Tools\Migrator;
use BinaryStudioAcademyTests\Tools\QueryRunner;
use BinaryStudioAcademyTests\Tools\Seeder;
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;

class TasksTest extends TestCase
{
    const QUERY_DIR = __DIR__ . '/../src/';

    /**
     * @var \PDO
     */
    private $connection;

    /**
     * @var QueryRunner
     */
    private $queryRunner;

    /**
     * @var Migrator
     */
    private $migrator;

    /**
     * @var Seeder
     */
    private $seeder;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        // Load configs
        $dotenv = new Dotenv(__DIR__ . '/../');
        $dotenv->load();
    }


    protected function setUp()
    {
        parent::setUp();

        $this->connection = (new ConnectionFactory())->make();

        $this->queryRunner = new QueryRunner($this->connection);
        $this->migrator = new Migrator($this->connection);
        $this->seeder = new Seeder($this->connection);

        $this->migrator->up();
        $this->seeder->seed();
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->migrator->down();
    }

    public function test_task1()
    {
        $query = $this->loadTaskQuery('task1');

        $results = $this->queryRunner->run($query, null, \PDO::FETCH_ASSOC);
        $this->assertCount(2, $results);

        $expected = [
            [
                'first_name' => 'Homer',
                'last_name' => 'Simpson',
                'age' => 47
            ],
            [
                'first_name' => 'Marge',
                'last_name' => 'Simpson',
                'age' => 39
            ]
        ];

        $this->assertArraySubset($expected, $results);
    }

    public function test_task2()
    {
        $query = $this->loadTaskQuery('task2');

        $results = $this->queryRunner->run($query, null, \PDO::FETCH_ASSOC);
        $this->assertCount(3, $results);
        $expected = [
            ['first_name' => 'Homer', 'last_name' => 'Simpson', 'age' => 47],
            ['first_name' => 'Barth', 'last_name' => 'Simpson', 'age' => 12],
            ['first_name' => 'Marge', 'last_name' => 'Simpson', 'age' => 39]
        ];
        $this->assertArraySubset($expected, $results);
    }

    public function test_task3()
    {
        $query = $this->loadTaskQuery('task3');
        $this->queryRunner->run($query);

        $results = $this->queryRunner->run(
            'show columns from users where Field = :field',
            ['field' => 'is_deleted'],
            \PDO::FETCH_ASSOC
        );

        $expected = [
            [
                'Field' => 'is_deleted',
                'Type' => 'tinyint(1)',
                'Default' => '0'
            ]
        ];

        $this->assertArraySubset($expected, $results);
    }

    public function test_task4()
    {
        $queryTask3 = $this->loadTaskQuery('task3');
        $this->queryRunner->run($queryTask3);

        $query = $this->loadTaskQuery('task4');
        $this->queryRunner->run($query);

        $results = $this->queryRunner->run(
            'select * from users where is_deleted = :isDeleted',
            ['isDeleted' => 1],
            \PDO::FETCH_ASSOC
        );

        $this->assertCount(1, $results);
        $expected = [
            ['first_name' => 'Test', 'last_name' => 'Tasty', 'age' => 25]
        ];
        $this->assertArraySubset($expected, $results);
    }

    public function test_task5()
    {
        $query = $this->loadTaskQuery('task5');

        $results = $this->queryRunner->run($query, null, \PDO::FETCH_ASSOC);
        $this->assertCount(2, $results);
        $expected = [
            ['first_name' => 'Test', 'last_name' => 'Tasty', 'age' => 25],
            ['first_name' => 'Barth', 'last_name' => 'Simpson', 'age' => 12]
        ];
        $this->assertArraySubset($expected, $results);
    }

    public function test_task6()
    {
        $query = $this->loadTaskQuery('task6');

        $results = $this->queryRunner->run($query, null, \PDO::FETCH_ASSOC);
        $this->assertCount(1, $results);
        $expected = [
            ['first_name' => 'Marge', 'last_name' => 'Simpson', 'age' => 39]
        ];
        $this->assertArraySubset($expected, $results);
    }

    public function test_select_user()
    {
        $query = $this->loadTaskQuery('task_test');

        $results = $this->queryRunner->run($query, null, \PDO::FETCH_ASSOC);

        $expected = [
            [
                'first_name' => 'Homer',
                'last_name' => 'Simpson',
                'age' => 47
            ]
        ];

        $this->assertArraySubset($expected, $results);
    }

    private function loadTaskQuery(string $name): string
    {
        return file_get_contents(self::QUERY_DIR . $name . '.sql');
    }
}

