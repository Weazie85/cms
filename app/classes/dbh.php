<?php

class Dbh {

    protected function connect() {

        $host = 'localhost';
        $dbName = 'cms';
        $username = 'root';
        $pwd = 'faxsq8Tx';
        
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbName", $username, $pwd);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $pdo;
            
        } catch (PDOException $e) {
            die("Error connecting to database: " . $e->getMessage() . "</br>");
        }
    }

}