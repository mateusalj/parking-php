<?php
try {
    $conectar = new PDO("mysql:host=localhost;dbname=estacionamento;charset=utf8", "root", "");
    // Sua lógica de banco de dados aqui
} catch (PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
}
