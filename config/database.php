<?php
class Database {
    private $host = "localhost";
    private $db_name = "cleste_aviation";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            // Primeiro tentar conectar ao MySQL sem database
            $this->conn = new PDO("mysql:host=" . $this->host, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Tentar criar o database se não existir
            $this->conn->exec("CREATE DATABASE IF NOT EXISTS $this->db_name");
            $this->conn->exec("USE $this->db_name");
            
            // Criar tabelas se não existirem
            $this->createTables();
            
        } catch(PDOException $exception) {
            // Se falhar, tentar conectar diretamente ao database (pode já existir)
            try {
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
                $this->conn->exec("set names utf8");
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                // Se ainda falhar, retornar null (usaremos fallback)
                $this->conn = null;
            }
        }
        return $this->conn;
    }

    private function createTables() {
        $tables = [
            "CREATE TABLE IF NOT EXISTS destinos (
                id INT PRIMARY KEY AUTO_INCREMENT,
                nome_pt VARCHAR(255) NOT NULL,
                nome_en VARCHAR(255) NOT NULL,
                descricao_pt TEXT,
                descricao_en TEXT,
                imagem VARCHAR(255),
                ativo BOOLEAN DEFAULT TRUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )",
            
            "CREATE TABLE IF NOT EXISTS pacotes (
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
            )",
            
            "CREATE TABLE IF NOT EXISTS depoimentos (
                id INT PRIMARY KEY AUTO_INCREMENT,
                texto_pt TEXT NOT NULL,
                texto_en TEXT NOT NULL,
                autor_pt VARCHAR(255),
                autor_en VARCHAR(255),
                ativo BOOLEAN DEFAULT TRUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )",
            
            "CREATE TABLE IF NOT EXISTS contatos (
                id INT PRIMARY KEY AUTO_INCREMENT,
                nome VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                telefone VARCHAR(20),
                mensagem TEXT NOT NULL,
                lido BOOLEAN DEFAULT FALSE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )",
            
            "CREATE TABLE IF NOT EXISTS newsletter (
                id INT PRIMARY KEY AUTO_INCREMENT,
                email VARCHAR(255) UNIQUE NOT NULL,
                ativo BOOLEAN DEFAULT TRUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )",
            
            "CREATE TABLE IF NOT EXISTS administradores (
                id INT PRIMARY KEY AUTO_INCREMENT,
                usuario VARCHAR(100) UNIQUE NOT NULL,
                senha VARCHAR(255) NOT NULL,
                nome VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )"
        ];

        foreach ($tables as $table) {
            $this->conn->exec($table);
        }

        // Inserir dados iniciais
        $this->insertInitialData();
    }

    private function insertInitialData() {
        // Verificar se já existem dados
        $check = $this->conn->query("SELECT COUNT(*) as count FROM administradores")->fetch();
        
        if ($check['count'] == 0) {
            // Inserir administrador (senha: password)
            $this->conn->exec("INSERT INTO administradores (usuario, senha, nome, email) VALUES 
                ('admin', '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador', 'admin@clesteaviation.com')");

            // Inserir destinos
            $this->conn->exec("INSERT INTO destinos (nome_pt, nome_en, descricao_pt, descricao_en) VALUES 
                ('Noruega', 'Norway', 'Tromsø - A capital do Ártico', 'Tromsø - The Arctic Capital'),
                ('Islândia', 'Iceland', 'Reiquejavique - Fogo e Gelo', 'Reykjavik - Fire and Ice'),
                ('Finlândia', 'Finland', 'Rovaniemi - Terra do Papai Noel', 'Rovaniemi - Santa''s Homeland'),
                ('Canadá', 'Canada', 'Yellowknife - Céus Deslumbrantes', 'Yellowknife - Dazzling Skies')");

            // Inserir pacotes
            $this->conn->exec("INSERT INTO pacotes (nome_pt, nome_en, descricao_pt, descricao_en, preco_pt, preco_en, duracao_pt, duracao_en) VALUES 
                ('Expedição Ártica', 'Arctic Expedition', 'Uma aventura única pelo Ártico', 'A unique Arctic adventure', 'A partir de R$ 5.999', 'From \$1,199', '5 noites', '5 nights'),
                ('Aurora Premium', 'Premium Aurora', 'Experiência premium para ver a Aurora', 'Premium Aurora viewing experience', 'A partir de R$ 7.499', 'From \$1,499', '7 noites', '7 nights'),
                ('Viagem dos Sonhos', 'Dream Journey', 'A viagem dos seus sonhos pelas terras do norte', 'Your dream journey through northern lands', 'A partir de R$ 9.999', 'From \$1,999', '10 noites', '10 nights')");

            // Inserir depoimentos
            $this->conn->exec("INSERT INTO depoimentos (texto_pt, texto_en, autor_pt, autor_en) VALUES 
                ('Experiência incrível! A equipe da Cleste foi excepcional e as auroras eram de tirar o fôlego.', 'Amazing experience! The Cleste team was exceptional and the auroras were breathtaking.', 'Mariana Silva', 'Mariana Silva'),
                ('Realizei um sonho de infância. Tudo foi perfeito, desde o hotel até os guias locais.', 'I fulfilled a childhood dream. Everything was perfect, from the hotel to the local guides.', 'Carlos Mendes', 'Carlos Mendes')");
        }
    }
}
?>