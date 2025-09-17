CREATE DATABASE skytravel;
USE skytravel;

CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    main_title VARCHAR(255) NOT NULL,
    main_subtitle TEXT NOT NULL,
    main_button VARCHAR(100) NOT NULL
);

CREATE TABLE destinations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL
);

CREATE TABLE offers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL
);

CREATE TABLE testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    text TEXT NOT NULL,
    destination VARCHAR(150) NOT NULL
);

CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO admin (username, password) VALUES ('admin','admin123');

INSERT INTO content (main_title, main_subtitle, main_button) VALUES
('Descubra o mundo com a SkyTravel',
 'Oferecemos as melhores experiências de viagem com pacotes exclusivos e preços incríveis para destinos nacionais e internacionais.',
 'Explorar Destinos');

INSERT INTO destinations (name, description, price) VALUES
('Fernando de Noronha','Paraíso tropical com praias intocadas e vida marinha exuberante.',2499.00),
('Gramado - RS','Experimente o clima europeu no Brasil com paisagens deslumbrantes.',1799.00),
('Orlando - EUA','O destino perfeito para famílias com os melhores parques temáticos.',5899.00);

INSERT INTO offers (name, description, price) VALUES
('Natal em Paris','Viva o magico natal europeu na cidade luz. Inclui hospedagem e city tour.',4299.00),
('Caribe Mexicano','7 noites em resort all inclusive com voo direto. Imperdível!',3899.00),
('Patagônia Argentina','Para os amantes de natureza e aventura. Inclui trekking e cruzeiro.',2999.00);

INSERT INTO testimonials (name, text, destination) VALUES
('Carlos Silva','A SkyTravel superou todas as minhas expectativas. Desde o atendimento até a execução da viagem, tudo foi perfeito. Com certeza usarei novamente!','Viagem para Lisboa'),
('Amanda Oliveira','Excelente agência! Me ajudaram a planejar a lua de mel dos sonhos dentro do meu orçamento. Todas as recomendações foram incríveis.','Lua de Mel em Maldives'),
('Ricardo Santos','Profissionalismo e qualidade de serviço excepcionais. Resolveram todos os imprevistos rapidamente e me mantiveram informado durante toda a viagem.','Tour pela Europa');
