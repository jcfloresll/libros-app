<?php

    $host = 'localhost';
    $dbname = 'appbooks';
    $user = 'xxapbbux';
    $pass = '4#p13k1Gs';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
    
?>