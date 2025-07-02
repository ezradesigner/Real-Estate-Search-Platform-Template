<?php

session_start();
require_once '../config.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'login') {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';
    
    if (empty($usuario) || empty($senha)) {
        header('Location: login.php?erro=campos_obrigatorios');
        exit;
    }
    
    try {
        $pdo = conectarBanco();
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE usuario = ? AND ativo = 1");
        $stmt->execute([$usuario]);
        $admin = $stmt->fetch();
        
        if ($admin && password_verify($senha, $admin['senha'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_usuario'] = $admin['usuario'];
            $_SESSION['admin_email'] = $admin['email'];
            
            header('Location: index.html');
            exit;
        } else {
            header('Location: login.php?erro=credenciais_invalidas');
            exit;
        }
    } catch (Exception $e) {
        header('Location: login.php?erro=erro_interno');
        exit;
    }
}

if ($action === 'logout') {
    session_destroy();
    header('Location: login.php?msg=logout_sucesso');
    exit;
}

// Verificar se está logado (para usar em outras páginas)
function verificarLogin() {
    if (!isset($_SESSION['admin_id'])) {
        header('Location: login.php?erro=acesso_negado');
        exit;
    }
}
?>
