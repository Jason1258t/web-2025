<?php
require './database.php';

function executeSqlFile($pdo, $filePath) {
    $sql = file_get_contents($filePath);
    
    try {
        $pdo->exec($sql);
        echo "Файл $filePath успешно выполнен\n";
    } catch (PDOException $e) {
        die("Ошибка при выполнении файла $filePath: " . $e->getMessage());
    }
}

try {
    $pdo = connectDatabase();
    
    executeSqlFile($pdo, __DIR__.'/sql/tables.sql');
    executeSqlFile($pdo, __DIR__.'/sql/users.sql');
    executeSqlFile($pdo, __DIR__.'/sql/posts.sql');
    
    echo "База данных успешно инициализирована!\n";
} catch (PDOException $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}