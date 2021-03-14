<?php
    include '../classes/autoloader.php';
    include '../config/config.php';

    class DanceEventController
    {
        public $teststring;

        public function __construct()
        {
            $this->teststring = 'Hello Test';
            $connection = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DB);

            if ($connection->connect_errno) {
                $this->teststring = 'Connection failed first if';
                exit();
            }
            /* check if server is alive */
            if ($connection->ping()) {
                $sql = "SELECT * FROM Artists";
                $result = $connection->query($sql);
                $this->teststring = $result;
            } else {
                $this->teststring = 'Connection failed second if';
            }

        }

        public function render()
        {
            echo $this->teststring;
        }
    }

?>