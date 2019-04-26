<?php

//declare(strict_types=1);

class BraftonConnection {

    public static $servername;
    private static $username;
    private static $passcode;
    public $connected;

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
     * return single user data from AWS db
     */
    public static function getClientData($connection,$name){
        if (!$connection->connect_error) {
            $users = "SELECT * FROM credentials WHERE client = '$name'";
            $result = mysqli_query($connection, $users);
            $arguments = [];
            if($result->num_rows>0){
                while ($row = $result->fetch_row()) {
                    $arguments['token'] = $row[6];
                    $arguments['link'] = $row[7];
                    $arguments['privacy'] = $row[8];
                }
            }
            return $arguments;
        }
    }
}