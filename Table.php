<?php
include("DBConn.php");

$q="CREATE TABLE `Info` (`id` INT NOT NULL AUTO_INCREMENT , `firstname` VARCHAR(20) NOT NULL , 
`lastname` VARCHAR(20) NOT NULL , `email` VARCHAR(30) NOT NULL , `phoneno` VARCHAR(20) NOT NULL , `address` VARCHAR(100) NOT NULL ,
 `age` INT NOT NULL ,`Gender` ENUM('Male','Female','Other','') NOT NULL ,`pdf` VARCHAR(40) NOT NULL, PRIMARY KEY (`id`))";

if(mysqli_query($conn, $q)) {
    echo "Table created\n<br>";
}
else{
    echo "Table error: ".mysqli_error($conn)."\n<br>";
}
?>