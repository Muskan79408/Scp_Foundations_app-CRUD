<?php

    include "credentials.php";
    
    // create connection to our database
    // mysqli requires address, username, password and database name
    $connection = new mysqli('localhost', $user, $pw, $db);
    
    // create variable to store records from our database table
    $Records = $connection->prepare("select * from scp_foundations_app");
    // run sql query
    $Records->execute();
    // store result of query
    $Result = $Records->get_result();


?>
