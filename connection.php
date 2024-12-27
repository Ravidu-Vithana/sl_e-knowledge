<?php

class Database{
    public static $connection;

    public static function setUpConnection(){
        if(!isset(Database::$connection)){
            Database::$connection = new mysqli("localhost","root","254680@Ryvk2002","student_management_db","3306");
        }
    }

    public static function iud($q){
        Database::setUpConnection();
        Database::$connection->query($q);

    }

    public static function search($q){
        Database::setUpConnection();
        $resultSet =  Database::$connection->query($q);
        return $resultSet;
    }

}

?>