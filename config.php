<?php

// Configurações do banco de dados
define('DB_HOST', 'localhost');
define('DB_NAME', ''); // nome do banco
define('DB_USER', ''); // usuário do banco
define('DB_PASS', ''); // senha do banco

// Configurações do site
define('SITE_URL', '');
define('SITE_NAME', 'Portal Imobiliário');

// Configurações de email SMTP HostGator
define('SMTP_HOST', '');
define('SMTP_PORT', 587);
define('SMTP_USER', '');
define('SMTP_PASS', '');

function conectarBanco() {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
        return $pdo;
    } catch (PDOException $e) {
        die("Erro de conexão: " . $e->getMessage());
    }
}
?>
