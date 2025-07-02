<?php
// config.php - Configurações do banco de dados

// Configurações do banco de dados HostGator
define('DB_HOST', 'localhost'); // ou o host fornecido pela HostGator
define('DB_NAME', 'brun3293_oohmedia'); // nome do banco
define('DB_USER', 'brun3293_admin'); // usuário do banco
define('DB_PASS', 'mz9*~nllPvh8'); // senha do banco

// Configurações do site
define('SITE_URL', 'https://teste.maybumaquinasagricolas.com.br');
define('SITE_NAME', 'Portal Imobiliário');

// Configurações de email SMTP HostGator
define('SMTP_HOST', 'mail.maybumaquinasagricolas.com.br');
define('SMTP_PORT', 587);
define('SMTP_USER', 'contato@maybumaquinasagricolas.com.br');
define('SMTP_PASS', 'sua_senha_email');

// Função para conectar ao banco
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