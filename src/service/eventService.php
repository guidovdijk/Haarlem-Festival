<?php
    include '../classes/autoloader.php';

    abstract class eventService {
        protected database $db;
        protected mysqli $conn;

        public function __construct() {
            $this->db = database::getInstance();

            $this->conn = $this->db->getConnection();
        }

        abstract protected function getEventPageContent();
    }

?>