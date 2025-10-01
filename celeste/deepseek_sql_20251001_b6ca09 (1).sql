-- Criação do banco de dados SkyTravel
CREATE DATABASE skytravel;
USE skytravel;

-- Tabela de usuários administradores
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de conteúdo do site (para multilíngua)
CREATE TABLE site_content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content_key VARCHAR(100) NOT NULL UNIQUE,
    content_pt TEXT NOT NULL,
    content_en TEXT NOT NULL,
    section VARCHAR(50) NOT NULL
);

-- Tabela de destinos
CREATE TABLE destinations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name_pt VARCHAR(100) NOT NULL,
    name_en VARCHAR(100) NOT NULL,
    description_pt TEXT NOT NULL,
    description_en TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    discount DECIMAL(5,2) DEFAULT 0,
    image_url VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de ofertas especiais
CREATE TABLE special_offers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title_pt VARCHAR(100) NOT NULL,
    title_en VARCHAR(100) NOT NULL,
    description_pt TEXT NOT NULL,
    description_en TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    discount_percent INT DEFAULT 0,
    tag_pt VARCHAR(50),
    tag_en VARCHAR(50),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de depoimentos
CREATE TABLE testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_name VARCHAR(100) NOT NULL,
    testimonial_pt TEXT NOT NULL,
    testimonial_en TEXT NOT NULL,
    destination_pt VARCHAR(100) NOT NULL,
    destination_en VARCHAR(100) NOT NULL,
    rating INT DEFAULT 5,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de configurações do site
CREATE TABLE site_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(50) NOT NULL UNIQUE,
    setting_value TEXT NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Inserir administrador padrão
INSERT INTO admins (username, password, email) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@skytravel.com');

-- Inserir conteúdo padrão em português e inglês
INSERT INTO site_content (content_key, content_pt, content_en, section) VALUES
-- Conteúdo principal
('main_title', 'Descubra o mundo com a SkyTravel', 'Discover the world with SkyTravel', 'hero'),
('main_subtitle', 'Oferecemos as melhores experiências de viagem com pacotes exclusivos e preços incríveis para destinos nacionais e internacionais.', 'We offer the best travel experiences with exclusive packages and amazing prices for national and international destinations.', 'hero'),
('main_button', 'Explorar Destinos', 'Explore Destinations', 'hero'),

-- Seções
('section_destinations', 'Destinos Populares', 'Popular Destinations', 'sections'),
('section_offers', 'Ofertas Especiais', 'Special Offers', 'sections'),
('section_testimonials', 'O que nossos clientes dizem', 'What our customers say', 'sections'),
('section_contact', 'Entre em Contato', 'Contact Us', 'sections'),

-- Rodapé
('footer_text', 'Sua próxima aventura começa aqui. Oferecemos as melhores experiências de viagem desde 2011.', 'Your next adventure starts here. We offer the best travel experiences since 2011.', 'footer'),
('copyright', '© 2023 SkyTravel - Todos os direitos reservados', '© 2023 SkyTravel - All rights reserved', 'footer'),

-- Formulários
('name_label', 'Nome', 'Name', 'forms'),
('email_label', 'Email', 'Email', 'forms'),
('message_label', 'Mensagem', 'Message', 'forms'),
('send_button', 'Enviar Mensagem', 'Send Message', 'forms'),
('search_placeholder', 'Para onde você quer ir?', 'Where do you want to go?', 'forms'),
('travelers_label', 'Viajantes', 'Travelers', 'forms'),
('search_button', 'Buscar', 'Search', 'forms'),

-- Navegação
('nav_home', 'Início', 'Home', 'navigation'),
('nav_destinations', 'Destinos', 'Destinations', 'navigation'),
('nav_offers', 'Pacotes', 'Packages', 'navigation'),
('nav_testimonials', 'Depoimentos', 'Testimonials', 'navigation'),
('nav_contact', 'Contato', 'Contact', 'navigation'),
('login_button', 'Entrar', 'Login', 'navigation'),
('register_button', 'Cadastrar', 'Register', 'navigation'),

-- Estatísticas
('stat_clients', 'Clientes Satisfeitos', 'Satisfied Customers', 'stats'),
('stat_destinations', 'Destinos Disponíveis', 'Available Destinations', 'stats'),
('stat_experience', 'Anos de Experiência', 'Years of Experience', 'stats'),
('stat_support', 'Suporte ao Cliente', 'Customer Support', 'stats');

-- Inserir destinos
INSERT INTO destinations (name_pt, name_en, description_pt, description_en, price, discount) VALUES
('Fernando de Noronha', 'Fernando de Noronha', 'Paraíso tropical com praias intocadas e vida marinha exuberante.', 'Tropical paradise with pristine beaches and exuberant marine life.', 2499.00, 10),
('Gramado - RS', 'Gramado - RS', 'Experimente o clima europeu no Brasil com paisagens deslumbrantes.', 'Experience the European climate in Brazil with stunning landscapes.', 1799.00, 0),
('Orlando - EUA', 'Orlando - USA', 'O destino perfeito para famílias com os melhores parques temáticos.', 'The perfect destination for families with the best theme parks.', 5899.00, 0);

-- Inserir ofertas especiais
INSERT INTO special_offers (title_pt, title_en, description_pt, description_en, price, discount_percent, tag_pt, tag_en) VALUES
('Natal em Paris', 'Christmas in Paris', 'Viva o magico natal europeu na cidade luz. Inclui hospedagem e city tour.', 'Experience the magical European Christmas in the city of lights. Includes accommodation and city tour.', 4299.00, 25, '-25%', '-25%'),
('Caribe Mexicano', 'Mexican Caribbean', '7 noites em resort all inclusive com voo direto. Imperdível!', '7 nights in all inclusive resort with direct flight. Unmissable!', 3899.00, 15, '-15%', '-15%'),
('Patagônia Argentina', 'Argentine Patagonia', 'Para os amantes de natureza e aventura. Inclui trekking e cruzeiro.', 'For nature and adventure lovers. Includes trekking and cruise.', 2999.00, 0, 'Promoção', 'Promotion');

-- Inserir depoimentos
INSERT INTO testimonials (client_name, testimonial_pt, testimonial_en, destination_pt, destination_en, rating) VALUES
('Carlos Silva', '"A SkyTravel superou todas as minhas expectativas. Desde o atendimento até a execução da viagem, tudo foi perfeito. Com certeza usarei novamente!"', '"SkyTravel exceeded all my expectations. From the service to the execution of the trip, everything was perfect. I will definitely use it again!"', 'Viagem para Lisboa', 'Trip to Lisbon', 5),
('Amanda Oliveira', '"Excelente agência! Me ajudaram a planejar a lua de mel dos sonhos dentro do meu orçamento. Todas as recomendações foram incríveis."', '"Excellent agency! They helped me plan the honeymoon of my dreams within my budget. All recommendations were amazing."', 'Lua de Mel em Maldives', 'Honeymoon in Maldives', 5),
('Ricardo Santos', '"Profissionalismo e qualidade de serviço excepcionais. Resolveram todos os imprevistos rapidamente e me mantiveram informado durante toda a viagem."', '"Exceptional professionalism and service quality. They quickly resolved all unforeseen issues and kept me informed throughout the trip."', 'Tour pela Europa', 'European Tour', 5);

-- Inserir configurações
INSERT INTO site_settings (setting_key, setting_value) VALUES
('site_name', 'SkyTravel'),
('contact_phone', '(11) 3456-7890'),
('contact_email', 'contato@skytravel.com'),
('color_scheme', 'default');