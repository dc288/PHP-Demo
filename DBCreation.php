<?php
$servername = "localhost";
$username = "root";
$password = "";

$conn=mysqli_connect($servername, $username, $password);

if($conn->connect_error){
    die("Connection  Failed: ". $conn->connect_error."\n<br>");
}

else{
    echo "Connected Successfully\n<br>";
}

$que="CREATE DATABASE lfg";

if(mysqli_query( $conn, $que)){
    echo "Database created successfully\n<br>";
}
else{
    echo "Error:".mysqli_error( $conn)."\n<br>";
}
?>