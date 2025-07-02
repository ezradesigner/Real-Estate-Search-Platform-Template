<?php
// admin/login.php - Página de login do admin

session_start();

// Se já estiver logado, redirecionar
if (isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

$erro = $_GET['erro'] ?? '';
$msg = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Portal Imobiliário</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <div class="text-center mb-8">
            <div class="bg-blue-500 text-white p-3 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                <i class="fas fa-lock text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Acesso Administrativo</h1>
            <p class="text-gray-600 mt-2">Entre com suas credenciais</p>
        </div>

        <?php if ($erro): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php
                switch ($erro) {
                    case 'campos_obrigatorios':
                        echo 'Usuário e senha são obrigatórios.';
                        break;
                    case 'credenciais_invalidas':
                        echo 'Usuário ou senha incorretos.';
                        break;
                    case 'acesso_negado':
                        echo 'Acesso negado. Faça login para continuar.';
                        break;
                    case 'erro_interno':
                        echo 'Erro interno do sistema. Tente novamente.';
                        break;
                    default:
                        echo 'Erro desconhecido.';
                }
                ?>
            </div>
        <?php endif; ?>

        <?php if ($msg === 'logout_sucesso'): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                Logout realizado com sucesso.
            </div>
        <?php endif; ?>

        <form method="POST" action="auth.php" class="space-y-4">
            <input type="hidden" name="action" value="login">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Usuário</label>
                <div class="relative">
                    <i class="fas fa-user absolute left-3 top-3 text-gray-400"></i>
                    <input type="text" name="usuario" required 
                           class="w-full pl-10 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Digite seu usuário">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Senha</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-3 top-3 text-gray-400"></i>
                    <input type="password" name="senha" required 
                           class="w-full pl-10 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Digite sua senha">
                </div>
            </div>

            <button type="submit" 
                    class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200 font-semibold">
                <i class="fas fa-sign-in-alt mr-2"></i>Entrar
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="../index.html" class="text-blue-600 hover:text-blue-800 text-sm">
                <i class="fas fa-arrow-left mr-1"></i>Voltar ao site
            </a>
        </div>

        <div class="mt-8 text-center text-sm text-gray-500">
            <p>Credenciais padrão:</p>
            <p><strong>Usuário:</strong> admin</p>
            <p><strong>Senha:</strong> admin123</p>
        </div>
    </div>
</body>
</html>