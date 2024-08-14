<?php
class Database {
  public static function getConnect(){
    $db_host = "localhost";
    $db_name = "ivshop";
    $db_user = "root";
    $db_pass = "mysql";

    $conn = "mysql:host=$db_host;dbname=$db_name;charset=utf8";
    return new PDO($conn,$db_user,$db_pass);
  }
}