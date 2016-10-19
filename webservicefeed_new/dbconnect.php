<?php
require_once("config.php");

class DBConnect {
    
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
       
    function getFeeds($current_date) {
        
        $date_time = explode(" ",$current_date);        
        $date_value = explode("-", $date_time[0]);
        $date_value_ = $date_value[2]. "-" . $date_value[1] . "-" . $date_value[0];        

        $stmt = $this->conn->prepare('SELECT * FROM feeds WHERE LastUpdate = unix_timestamp(?)');
        $stmt->bind_param('s', $date_value_);

        $stmt->execute();

        $result = $stmt->get_result();
        $records = array();
        while ($row = $result->fetch_assoc()) {
            $records[] = $row;
        }        
        return $records;
    }
    function close_connection() {
        $this->conn->close();
    }  
}
?>