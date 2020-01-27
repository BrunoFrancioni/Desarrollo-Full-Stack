<?php
    $connection = new mysqli('localhost', 'root', 'root', 'gdlwebcamp');

    if($connection->connect_error) {
        echo $error -> $connection->connect_error;
    }
?>