<?php

class MysqlDB
{
    private $hostname = 'localhost';

    private $database = 'urlsdb';

    private $username = 'urls_service';

    private $password = 'urls_service';

    private $connection;

    private $connected = false;

    public function __construct()
    {
        $this->connect($this->hostname, $this->database, $this->username, $this->password);
    }

    private function connect($hostname, $database, $username, $password)
    {
        $this->connection = mysqli_connect($hostname, $username, $password, $database);
        if($this->connection)
            $this->connected = true;
    }

    public function closeConnection()
    {
        $this->connection = null;
        $this->connected = false;
    }

    public function isConnected() {
        return $this->connected;
    }

    public function insertUrl($data) {
        $stmt = $this->connection->prepare("INSERT INTO urls (url, content_length) VALUES(?, ?)");
        $stmt->bind_param("sis", $data['url'], $data['content_length']);
        $stmt->execute();
    }
}
?>