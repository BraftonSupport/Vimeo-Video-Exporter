<?php

//declare(strict_types=1);

class BraftonConnection {

    public static $servername;
    private static $username;
    private static $passcode;
    private static $creation = null;
    public $connection;


    /**
     * private constructor to ensure only 1 instance of class is created
     */
     private function __construct($server, $user,$passcode, $db){
        $this->connection = new mysqli($server, $user,$passcode, $db);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
     }

    /**
     * make initial connection to AWS db (replace with singleton)
     */
    public static function dbConnect($server,$user,$passcode){
        $conn = new mysqli($server, $user,$passcode, 'vimeo');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
    /**
     * create new instance of class if it does not already exist
     * @return BraftonConnection object
     */
    public static function getCreation($server, $user,$passcode, $db){
        if(!self::$creation) {
            self::$creation = new BraftonConnection($server, $user,$passcode, $db);
        }
        return self::$creation;
    }

    /**
     * get actual connection
     * @return mysql connection object
     */
    public function getConnection(){
        return $this->connection;
    }
    /**
     * return single user data from AWS db
     */
    public static function getClientData($connection,$name){
        if (!$connection->connect_error) {
            $users = "SELECT * FROM credentials WHERE client = '$name'";
            $result = mysqli_query($connection, $users);
            $arguments = [];
            if($result->num_rows>0){
                while ($row = $result->fetch_row()) {
                    $arguments['token'] = $row[5];
                    $arguments['link'] = $row[6];
                    $arguments['privacy'] = $row[7];
                }
            }
            return $arguments;
        }
    }
}