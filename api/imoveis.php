<?php
// api/imoveis.php - API para gerenciar imóveis

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config.php';

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

try {
    $pdo = conectarBanco();
    
    switch ($method) {
        case 'GET':
            if (isset($_GET['id'])) {
                // Buscar imóvel específico
                $stmt = $pdo->prepare("SELECT * FROM imoveis WHERE id = ? AND ativo = 1");
                $stmt->execute([$_GET['id']]);
                $imovel = $stmt->fetch();
                
                if ($imovel) {
                    echo json_encode(['success' => true, 'data' => $imovel]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Imóvel não encontrado']);
                }
            } else {
                // Buscar todos os imóveis
                $where = "WHERE ativo = 1";
                $params = [];
                
                // Filtros
                if (isset($_GET['tipo']) && !empty($_GET['tipo'])) {
                    $where .= " AND tipo = ?";
                    $params[] = $_GET['tipo'];
                }
                
                if (isset($_GET['busca']) && !empty($_GET['busca'])) {
                    $where .= " AND (titulo LIKE ? OR endereco LIKE ?)";
                    $busca = '%' . $_GET['busca'] . '%';
                    $params[] = $busca;
                    $params[] = $busca;
                }
                
                if (isset($_GET['destaque']) && $_GET['destaque'] == '1') {
                    $where .= " AND destaque = 1";
                }
                
                $stmt = $pdo->prepare("SELECT * FROM imoveis $where ORDER BY destaque DESC, data_criacao DESC");
                $stmt->execute($params);
                $imoveis = $stmt->fetchAll();
                
                echo json_encode(['success' => true, 'data' => $imoveis]);
            }
            break;
            
        case 'POST':
            // Adicionar novo imóvel (apenas admin)
            if (!isset($_SESSION['admin_id'])) {
                echo json_encode(['success' => false, 'message' => 'Acesso negado']);
                break;
            }
            
            $stmt = $pdo->prepare("
                INSERT INTO imoveis (titulo, tipo, endereco, preco, quartos, banheiros, area, imagem, destaque) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $resultado = $stmt->execute([
                $input['titulo'],
                $input['tipo'],
                $input['endereco'],
                $input['preco'],
                $input['quartos'],
                $input['banheiros'],
                $input['area'],
                $input['imagem'],
                $input['destaque'] ? 1 : 0
            ]);
            
            if ($resultado) {
                echo json_encode(['success' => true, 'message' => 'Imóvel adicionado com sucesso']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erro ao adicionar imóvel']);
            }
            break;
            
        case 'PUT':
            // Atualizar imóvel (apenas admin)
            if (!isset($_SESSION['admin_id'])) {
                echo json_encode(['success' => false, 'message' => 'Acesso negado']);
                break;
            }
            
            $stmt = $pdo->prepare("
                UPDATE imoveis SET 
                titulo = ?, tipo = ?, endereco = ?, preco = ?, 
                quartos = ?, banheiros = ?, area = ?, imagem = ?, destaque = ?
                WHERE id = ?
            ");
            
            $resultado = $stmt->execute([
                $input['titulo'],
                $input['tipo'],
                $input['endereco'],
                $input['preco'],
                $input['quartos'],
                $input['banheiros'],
                $input['area'],
                $input['imagem'],
                $input['destaque'] ? 1 : 0,
                $input['id']
            ]);
            
            if ($resultado) {
                echo json_encode(['success' => true, 'message' => 'Imóvel atualizado com sucesso']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erro ao atualizar imóvel']);
            }
            break;
            
        case 'DELETE':
            // Excluir imóvel (apenas admin) - exclusão lógica
            if (!isset($_SESSION['admin_id'])) {
                echo json_encode(['success' => false, 'message' => 'Acesso negado']);
                break;
            }
            
            $id = $_GET['id'] ?? null;
            if (!$id) {
                echo json_encode(['success' => false, 'message' => 'ID do imóvel é obrigatório']);
                break;
            }
            
            $stmt = $pdo->prepare("UPDATE imoveis SET ativo = 0 WHERE id = ?");
            $resultado = $stmt->execute([$id]);
            
            if ($resultado) {
                echo json_encode(['success' => true, 'message' => 'Imóvel excluído com sucesso']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erro ao excluir imóvel']);
            }
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Método não permitido']);
            break;
    }
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erro interno: ' . $e->getMessage()]);
}
?>
