<?php
$host= "192.168.0.221";
$user= "root";
$password = "bitrix";
$database = "test";


 $conn = new mysqli($host, $user, $password, $database);
    
 if ($conn->connect_error)
     die("Connection failed: " .$conn->connect_error);
//  else echo "conncetion successfull";    


?>