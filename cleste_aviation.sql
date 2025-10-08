CREATE DATABASE cleste_aviation;
USE cleste_aviation;

-- Tabela de configurações do site
CREATE TABLE site_config (
    id INT PRIMARY KEY AUTO_INCREMENT,
    chave VARCHAR(100) UNIQUE NOT NULL,
    valor_pt TEXT,
    valor_en TEXT,
    tipo VARCHAR(50)
);

-- Tabela de destinos
CREATE TABLE destinos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome_pt VARCHAR(255) NOT NULL,
    nome_en VARCHAR(255) NOT NULL,
    descricao_pt TEXT,
    descricao_en TEXT,
    imagem VARCHAR(255),
    ativo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de pacotes
CREATE TABLE pacotes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome_pt VARCHAR(255) NOT NULL,
    nome_en VARCHAR(255) NOT NULL,
    descricao_pt TEXT,
    descricao_en TEXT,
    preco_pt VARCHAR(100),
    preco_en VARCHAR(100),
    duracao_pt VARCHAR(100),
    duracao_en VARCHAR(100),
    imagem VARCHAR(255),
    ativo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de depoimentos
CREATE TABLE depoimentos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    texto_pt TEXT NOT NULL,
    texto_en TEXT NOT NULL,
    autor_pt VARCHAR(255),
    autor_en VARCHAR(255),
    ativo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de contatos
CREATE TABLE contatos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telefone VARCHAR(20),
    mensagem TEXT NOT NULL,
    lido BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de newsletter
CREATE TABLE newsletter (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    ativo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de administradores
CREATE TABLE administradores (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Inserir dados iniciais
INSERT INTO administradores (usuario, senha, nome, email) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador', 'admin@clesteaviation.com');

-- Inserir destinos iniciais
INSERT INTO destinos (nome_pt, nome_en, descricao_pt, descricao_en, imagem) VALUES 
('Noruega', 'Norway', 'Tromsø - A capital do Ártico', 'Tromsø - The Arctic Capital', 'norway.jpg'),
('Islândia', 'Iceland', 'Reiquejavique - Fogo e Gelo', 'Reykjavik - Fire and Ice', 'iceland.jpg'),
('Finlândia', 'Finland', 'Rovaniemi - Terra do Papai Noel', 'Rovaniemi - Santa''s Homeland', 'finland.jpg'),
('Canadá', 'Canada', 'Yellowknife - Céus Deslumbrantes', 'Yellowknife - Dazzling Skies', 'canada.jpg');

-- Inserir pacotes iniciais
INSERT INTO pacotes (nome_pt, nome_en, descricao_pt, descricao_en, preco_pt, preco_en, duracao_pt, duracao_en, imagem) VALUES 
('Expedição Ártica', 'Arctic Expedition', 'Uma aventura única pelo Ártico', 'A unique Arctic adventure', 'A partir de R$ 5.999', 'From $1,199', '5 noites', '5 nights', 'pacote1.jpg'),
('Aurora Premium', 'Premium Aurora', 'Experiência premium para ver a Aurora', 'Premium Aurora viewing experience', 'A partir de R$ 7.499', 'From $1,499', '7 noites', '7 nights', 'pacote2.jpg'),
('Viagem dos Sonhos', 'Dream Journey', 'A viagem dos seus sonhos pelas terras do norte', 'Your dream journey through northern lands', 'A partir de R$ 9.999', 'From $1,999', '10 noites', '10 nights', 'pacote3.jpg');

-- Inserir depoimentos iniciais
INSERT INTO depoimentos (texto_pt, texto_en, autor_pt, autor_en) VALUES 
('Experiência incrível! A equipe da Cleste foi excepcional e as auroras eram de tirar o fôlego.', 'Amazing experience! The Cleste team was exceptional and the auroras were breathtaking.', 'Mariana Silva', 'Mariana Silva'),
('Realizei um sonho de infância. Tudo foi perfeito, desde o hotel até os guias locais.', 'I fulfilled a childhood dream. Everything was perfect, from the hotel to the local guides.', 'Carlos Mendes', 'Carlos Mendes');