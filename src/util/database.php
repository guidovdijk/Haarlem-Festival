<?php
include_once '../config/config.php';

class database {
    private mysqli $conn;
    private static $database;

    private function __construct(){
        $this->conn = $this->dbConnect();
    }

    /** 
     * Static method to create an object instance once. 
     * After that it will reuse it for all other requests.
     * 
     * @return database
    */
    public static function getInstance() : database
    {
        if(is_null(self::$database)){
            self::$database = new database();
        }

        return self::$database;
    }

    // Get connection to the database
    public function getConnection() : mysqli {
        return $this->conn;
    }

    // Close connection of the database
    public function closeConnection() : void {
        $this->conn->close();
    }

    /**
     * Create connection to the database, throw error if connection cannot be made
     * 
     * @return mysqli
    */
    private function dbConnect() : mysqli {
        $conn = mysqli_connect("localhost", "root", "", "test");
        
        if(!$conn){
            throw new DomainException("Could not make a connection to the database");
        }

        return $conn;
    }

    public function uploadImage(string $tmpName, string $name) : bool
    {
        $target_file = UPLOAD_PATH . basename($name);
    
        // Select file type
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
        // Valid file extensions
        $extensions_arr = array("jpg","jpeg","png");
    
        // Check extension
        if(!in_array($imageFileType,$extensions_arr) ){
            throw new Exception("File type not supported");
        }

        if(move_uploaded_file($tmpName, $target_file)){
            return true;
        } else {
            throw new RuntimeException('Failed to move uploaded file.');
        }
    }

    /**
     * Disable the cloning of this singleton class.
     * 
     * @return void
     */
    final public function __clone()
    {
        throw new Exception('Cannot clone a singleton.');
    }
}

?>