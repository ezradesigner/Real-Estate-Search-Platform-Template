<?php
// admin/painel.php - Back-end simplificado que utiliza a API existente

require_once '../config.php';
require_once 'auth.php';

verificarLogin();

header('Content-Type: application/json');

try {
    // Proxy para a API existente
    if (isset($_GET['action']) && $_GET['action'] === 'stats') {
        // Estatísticas específicas do painel admin
        $pdo = conectarBanco();
        $totalImoveis = $pdo->query("SELECT COUNT(*) FROM imoveis WHERE ativo = 1")->fetchColumn();
        $totalDestaque = $pdo->query("SELECT COUNT(*) FROM imoveis WHERE destaque = 1 AND ativo = 1")->fetchColumn();
        
        echo json_encode([
            'success' => true,
            'data' => [
                'total_imoveis' => $totalImoveis,
                'total_destaque' => $totalDestaque
            ]
        ]);
    } else {
        // Redirecionar outras requisições para a API principal
        require_once '../api/imoveis.php';
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}