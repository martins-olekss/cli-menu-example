<?php

class Database
{
    public $connection;

    public function __construct()
    {
        $this->connection = new PDO('sqlite:cli.sqlite3');
        $this->connection->setAttribute(PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION);
    }

    public function truncate()
    {
        try {
            $this->connection->exec('DELETE FROM messages');

        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $this;
    }

    public function drop()
    {
        try {
            $this->connection->exec('DROP TABLE messages');

        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $this;
    }

    public function create()
    {
        $this->connection->exec('CREATE TABLE IF NOT EXISTS messages (
                    id INTEGER PRIMARY KEY, 
                    title TEXT, 
                    message TEXT, 
                    time INTEGER)');
        return $this;
    }

    public function close()
    {
        $this->connection = null;
    }

    public function createMessage($msg)
    {
        $messageData = array(
            'title' => 'Hello123!',
            'message' => $msg,
            'time' => 1327301464
        );

        $insert = 'INSERT INTO messages (title, message, time) 
                VALUES (:title, :message, :time)';

        try {
            $stmt = $this->connection->prepare($insert);

            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':message', $message);
            $stmt->bindParam(':time', $time);

            $title = $messageData['title'];
            $message = $messageData['message'];
            $time = $messageData['time'];

            // Execute statement
            $stmt->execute();

        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $this;
    }

    public function showLastMessage()
    {
        try {
            $result = $this->connection->query('SELECT * FROM messages ORDER BY id DESC LIMIT 1');

            foreach ($result as $row) {
                echo "Id: " . $row['id'];
                echo "\tTitle: " . $row['title'];
                echo "\tMessage: " . $row['message'];
                echo "\tTime: " . $row['time'];
                echo "\n";
            }


        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $this;
    }

    public function showMessages()
    {
        try {
            $result = $this->connection->query('SELECT * FROM messages ORDER BY id DESC LIMIT 10');

            foreach ($result as $row) {
                echo "Id: " . $row['id'];
                echo "\tTitle: " . $row['title'];
                echo "\tMessage: " . $row['message'];
                echo "\tTime: " . $row['time'];
                echo "\n";
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $this;
    }
}