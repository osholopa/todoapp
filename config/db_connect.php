<?php

    //connect to database
    $conn = mysqli_connect('localhost', 'username', 'password', 'database_name');

    //check the connection
    if(!$conn) {
        echo 'Connection error: ' . mysqli_connect_error();
    }

?>