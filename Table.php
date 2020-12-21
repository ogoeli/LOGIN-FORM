<?php 
 include "cad.php";
// id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
// username VARCHAR(50) NOT NULL UNIQUE,
// password VARCHAR(255) NOT NULL,
 // created_at DATETIME DEFAULT,
//  CURRENT_TIMESTAMP
// );

$sql = "CREATE TABLE users(
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    
 username VARCHAR(50) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL,
 created_at DATETIME DEFAULT,
 CURRENT_TIMESTAMP    )";
    // echo "table created successfully"
     $result = ExecuteQuery($sql, "Table created successfully");
   echo $result;

?>