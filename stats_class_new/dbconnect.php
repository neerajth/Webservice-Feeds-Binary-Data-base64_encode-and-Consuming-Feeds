<?php
require_once("config.php");

class DBConnect {
    
    private $tablename = "DailyStats";
    
    /*singleton pattern instance*/
    private static $instance = null;
    private function __construct()
    {
        $this->conn = new mysqli(HOST, USER, PASS, DB);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null)
        {
          self::$instance = new DBConnect();
        }
    return self::$instance;
    }
       
    
    private function tableCreateIfNot($table) {  
        $sql = "CREATE TABLE IF NOT EXISTS ".$table." (
          `Id` int(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `LastUpdate` datetime NOT NULL UNIQUE KEY,
          `HitCount` int(11) NOT NULL,
          `LastTag` varchar(32) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
        $this->conn->query($sql);        
    }
    
    public function insertFeeds($data) {        
        
        $this->tableCreateIfNot($this->tablename);
        echo "<pre>"; print_r( $data ); echo "</pre>";

        $query = "INSERT INTO ".$this->tablename." (LastUpdate, HitCount, LastTag) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE LastUpdate=VALUES(LastUpdate), HitCount=VALUES(HitCount), LastTag=VALUES(LastTag)";

        $statement = $this->conn->prepare($query); // Prepare query for execution

        $statement->bind_param('sis', date("Y-m-d", $data[0]), $data[1], $data[2]);
        $statement->execute();        
    }
    
    function close_connection() {
        $this->conn->close();
    }  
}
?>