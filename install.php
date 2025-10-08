<?php
// Arquivo de instalação do sistema
echo "<h1>Instalação Cleste Aviation</h1>";

// Configurações do banco
$host = "localhost";
$username = "root";
$password = "";
$dbname = "cleste_aviation";

try {
    // Conectar ao MySQL (sem selecionar database)
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Criar database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $pdo->exec("USE $dbname");
    
    echo "<p>Database criada com sucesso!</p>";
    
    // Criar tabelas
    $sql = "
    -- Tabela de destinos
    CREATE TABLE IF NOT EXISTS destinos (
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
    CREATE TABLE IF NOT EXISTS pacotes (
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
    CREATE TABLE IF NOT EXISTS depoimentos (
        id INT PRIMARY KEY AUTO_INCREMENT,
        texto_pt TEXT NOT NULL,
        texto_en TEXT NOT NULL,
        autor_pt VARCHAR(255),
        autor_en VARCHAR(255),
        ativo BOOLEAN DEFAULT TRUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    -- Tabela de contatos
    CREATE TABLE IF NOT EXISTS contatos (
        id INT PRIMARY KEY AUTO_INCREMENT,
        nome VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        telefone VARCHAR(20),
        mensagem TEXT NOT NULL,
        lido BOOLEAN DEFAULT FALSE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    -- Tabela de newsletter
    CREATE TABLE IF NOT EXISTS newsletter (
        id INT PRIMARY KEY AUTO_INCREMENT,
        email VARCHAR(255) UNIQUE NOT NULL,
        ativo BOOLEAN DEFAULT TRUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    -- Tabela de administradores
    CREATE TABLE IF NOT EXISTS administradores (
        id INT PRIMARY KEY AUTO_INCREMENT,
        usuario VARCHAR(100) UNIQUE NOT NULL,
        senha VARCHAR(255) NOT NULL,
        nome VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );";
    
    $pdo->exec($sql);
    echo "<p>Tabelas criadas com sucesso!</p>";
    
    // Inserir dados iniciais
    $insert_sql = "
    -- Administrador padrão (senha: 'password')
    INSERT IGNORE INTO administradores (usuario, senha, nome, email) VALUES 
    ('admin', '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador', 'admin@clesteaviation.com');

    -- Destinos iniciais
    INSERT IGNORE INTO destinos (nome_pt, nome_en, descricao_pt, descricao_en) VALUES 
    ('Noruega', 'Norway', 'Tromsø - A capital do Ártico', 'Tromsø - The Arctic Capital'),
    ('Islândia', 'Iceland', 'Reiquejavique - Fogo e Gelo', 'Reykjavik - Fire and Ice'),
    ('Finlândia', 'Finland', 'Rovaniemi - Terra do Papai Noel', 'Rovaniemi - Santa''s Homeland'),
    ('Canadá', 'Canada', 'Yellowknife - Céus Deslumbrantes', 'Yellowknife - Dazzling Skies');

    -- Pacotes iniciais
    INSERT IGNORE INTO pacotes (nome_pt, nome_en, descricao_pt, descricao_en, preco_pt, preco_en, duracao_pt, duracao_en) VALUES 
    ('Expedição Ártica', 'Arctic Expedition', 'Uma aventura única pelo Ártico', 'A unique Arctic adventure', 'A partir de R$ 5.999', 'From \$1,199', '5 noites', '5 nights'),
    ('Aurora Premium', 'Premium Aurora', 'Experiência premium para ver a Aurora', 'Premium Aurora viewing experience', 'A partir de R$ 7.499', 'From \$1,499', '7 noites', '7 nights'),
    ('Viagem dos Sonhos', 'Dream Journey', 'A viagem dos seus sonhos pelas terras do norte', 'Your dream journey through northern lands', 'A partir de R$ 9.999', 'From \$1,999', '10 noites', '10 nights');

    -- Depoimentos iniciais
    INSERT IGNORE INTO depoimentos (texto_pt, texto_en, autor_pt, autor_en) VALUES 
    ('Experiência incrível! A equipe da Cleste foi excepcional e as auroras eram de tirar o fôlego.', 'Amazing experience! The Cleste team was exceptional and the auroras were breathtaking.', 'Mariana Silva', 'Mariana Silva'),
    ('Realizei um sonho de infância. Tudo foi perfeito, desde o hotel até os guias locais.', 'I fulfilled a childhood dream. Everything was perfect, from the hotel to the local guides.', 'Carlos Mendes', 'Carlos Mendes');";
    
    $pdo->exec($insert_sql);
    echo "<p>Dados iniciais inseridos com sucesso!</p>";
    
    echo "<h2 style='color: green;'>Instalação concluída com sucesso!</h2>";
    echo "<p><a href='index.php'>Acessar o Site</a> | <a href='admin/login.php'>Painel Admin</a></p>";
    echo "<p><strong>Credenciais do Admin:</strong><br>Usuário: admin<br>Senha: password</p>";
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>Erro na instalação: " . $e->getMessage() . "</p>";
    echo "<p>Verifique se o MySQL está rodando e as credenciais estão corretas.</p>";
}
?>