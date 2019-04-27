<?php
    include_once ('verdicts.php');

    class Database {
        private $host = 'localhost';
        private $username = 'administrator';
        private $password = "qwe123q1";
        private $db_name = "hackbd";
        public $conn;

        public function getConnection() {
            $this->conn = null;

            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            //var_dump($this->conn);
            if ($this->conn->connect_error) {
                fail("Connection failed: " . $this->conn->connect_error);
            }
            return $this->conn;
        }

        public function closeConnection() {
            $this->conn->close();
        }
    }
?>