-- database.sql - Estrutura do banco de dados

-- Criar tabela de imóveis
CREATE TABLE IF NOT EXISTS imoveis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    tipo ENUM('apartamento', 'casa', 'terreno', 'comercial') NOT NULL,
    endereco TEXT NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    quartos INT NOT NULL,
    banheiros INT NOT NULL,
    area INT NOT NULL,
    imagem VARCHAR(500) NOT NULL,
    destaque BOOLEAN DEFAULT FALSE,
    ativo BOOLEAN DEFAULT TRUE,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Criar tabela de administradores (simples)
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    ativo BOOLEAN DEFAULT TRUE,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Criar tabela de contatos/leads
CREATE TABLE IF NOT EXISTS contatos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefone VARCHAR(20),
    mensagem TEXT,
    imovel_id INT,
    data_contato TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (imovel_id) REFERENCES imoveis(id)
);

-- Inserir admin padrão (senha: admin123)
INSERT INTO admins (usuario, senha, email) VALUES 
('admin', '$2a$12$yPCBQU8mjFN07nKDwXr/duBqTlo9t1e.X02pBACYj0s.ApiviWk5C', 'girlan@girlan.com.br');

-- Inserir alguns imóveis de exemplo
INSERT INTO imoveis (titulo, tipo, endereco, preco, quartos, banheiros, area, imagem, destaque) VALUES
('Apartamento Moderno no Centro', 'apartamento', 'Rua das Flores, 123 - Centro, São Paulo', 350000.00, 2, 1, 65, 'https://via.placeholder.com/400x300/4F46E5/FFFFFF?text=Apartamento', TRUE),
('Casa Espaçosa com Jardim', 'casa', 'Rua das Palmeiras, 456 - Jardins, São Paulo', 750000.00, 3, 2, 120, 'https://via.placeholder.com/400x300/10B981/FFFFFF?text=Casa', TRUE),
('Loft Moderno Vila Madalena', 'apartamento', 'Rua Harmonia, 789 - Vila Madalena, São Paulo', 450000.00, 1, 1, 45, 'https://via.placeholder.com/400x300/F59E0B/FFFFFF?text=Loft', FALSE);