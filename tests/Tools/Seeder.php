<?php

namespace BinaryStudioAcademyTests\Tools;

class Seeder
{
    /**
     * @var \PDO
     */
    private $connection;

    const USERS = [
        ['first_name' => 'Test', 'last_name' => 'Tasty', 'age' => 25],
        ['first_name' => 'Homer', 'last_name' => 'Simpson', 'age' => 47],
        ['first_name' => 'Barth', 'last_name' => 'Simpson', 'age' => 12],
        ['first_name' => 'Marge', 'last_name' => 'Simpson', 'age' => 39]
    ];

    const TICKETS = [
        [
            'title' => 'Noord',
            'country' => 'Aruba',
            'price' => '111'
        ],
        [
            'title' => 'Santorini',
            'country' => 'Greece',
            'price' => '222'
        ],
        [
            'title' => 'Tenerife',
            'country' => 'Spain',
            'price' => '333'
        ],
        [
            'title' => 'Lagos',
            'country' => 'Portugal',
            'price' => '444'
        ]
    ];

    const BOOKINGS = [
        ['user_id' => 2, 'ticket_id' => 1], //total 666
        ['user_id' => 2, 'ticket_id' => 2],
        ['user_id' => 2, 'ticket_id' => 3],

        ['user_id' => 3, 'ticket_id' => 2], //total 555
        ['user_id' => 3, 'ticket_id' => 3],

        ['user_id' => 4, 'ticket_id' => 3], //total 888
        ['user_id' => 4, 'ticket_id' => 1],
        ['user_id' => 4, 'ticket_id' => 4],
    ];

    public function __construct(\PDO $pdo)
    {
        $this->connection = $pdo;
    }

    public function seed()
    {
        $this->seedUsers();
        $this->seedBooks();
        $this->seedUsersBooks();
    }

    private function seedUsers()
    {
        foreach(self::USERS as $user) {
            $query = 'INSERT INTO users (first_name, last_name, age) values (:first_name, :last_name, :age)';

            $this->connection->prepare($query)->execute([
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'age' => $user['age']
            ]);
        }
    }

    private function seedBooks()
    {
        foreach(self::TICKETS as $ticket) {
            $query = 'INSERT INTO tickets (title, country, price) values (:title, :country, :price)';

            $this->connection->prepare($query)->execute([
                'title' => $ticket['title'],
                'country' => $ticket['country'],
                'price' => $ticket['price']
            ]);
        }
    }

    private function seedUsersBooks()
    {
        foreach(self::BOOKINGS as $booking) {
            $query = 'INSERT INTO bookings (user_id, ticket_id) values (:user_id, :ticket_id)';

            $this->connection->prepare($query)->execute([
                'user_id' => $booking['user_id'],
                'ticket_id' => $booking['ticket_id']
            ]);
        }
    }
}
