<?php
function connectDatabase(): PDO
{
    $host = 'localhost';
    $dbname = 'blog';
    $username = 'root';
    $password = '';

    $dsn = "mysql:host=$host;dbname=$dbname";
    try {
        return new PDO($dsn, $username, $password);
    } catch (Exception $e) {
        die('Database connection error '.$e->getMessage());
    }
}
