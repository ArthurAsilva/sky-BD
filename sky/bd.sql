-- SkyTravel Database
CREATE DATABASE IF NOT EXISTS skytravel;
USE skytravel;

-- Tabela de Administradores
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    full_name VARCHAR(100),
    avatar VARCHAR(255),
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Conteúdo Multilíngua
CREATE TABLE site_content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content_key VARCHAR(100) NOT NULL UNIQUE,
    content_pt TEXT NOT NULL,
    content_en TEXT NOT NULL,
    section VARCHAR(50) NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela de Destinos
CREATE TABLE destinations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name_pt VARCHAR(100) NOT NULL,
    name_en VARCHAR(100) NOT NULL,
    description_pt TEXT NOT NULL,
    description_en TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    discount DECIMAL(5,2) DEFAULT 0,
    image_url VARCHAR(255),
    country_pt VARCHAR(50),
    country_en VARCHAR(50),
    duration_days INT,
    is_featured BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Ofertas Especiais
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
    image_url VARCHAR(255),
    start_date DATE,
    end_date DATE,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Depoimentos
CREATE TABLE testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_name VARCHAR(100) NOT NULL,
    client_avatar VARCHAR(255),
    testimonial_pt TEXT NOT NULL,
    testimonial_en TEXT NOT NULL,
    destination_pt VARCHAR(100) NOT NULL,
    destination_en VARCHAR(100) NOT NULL,
    rating INT DEFAULT 5,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Configurações
CREATE TABLE site_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(50) NOT NULL UNIQUE,
    setting_value TEXT NOT NULL,
    description TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Inserir Administrador Padrão
INSERT INTO admins (username, password, email, full_name) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@skytravel.com', 'Administrador Principal');

-- Inserir Conteúdo do Site
INSERT INTO site_content (content_key, content_pt, content_en, section) VALUES
('main_title', 'Descubra o Mundo com a SkyTravel', 'Discover the World with SkyTravel', 'hero'),
('main_subtitle', 'Vivências únicas que transformam sua perspectiva do mundo. Mais de 50 destinos incríveis esperam por você.', 'Unique experiences that transform your perspective of the world. Over 50 amazing destinations await you.', 'hero'),
('main_button', 'Começar Aventura', 'Start Adventure', 'hero'),
('section_destinations', 'Destinos em Destaque', 'Featured Destinations', 'sections'),
('section_offers', 'Ofertas Exclusivas', 'Exclusive Offers', 'sections'),
('section_testimonials', 'Histórias de Viajantes', 'Traveler Stories', 'sections'),
('section_contact', 'Pronto para Viajar?', 'Ready to Travel?', 'sections'),
('footer_text', 'Sua jornada inesquecível começa aqui. Transformamos sonhos em realidade desde 2012.', 'Your unforgettable journey starts here. We turn dreams into reality since 2012.', 'footer'),
('copyright', '© 2024 SkyTravel. Todos os direitos reservados.', '© 2024 SkyTravel. All rights reserved.', 'footer'),
('search_placeholder', 'Para onde sonha viajar?', 'Where do you dream of traveling?', 'forms'),
('travelers_label', 'Viajantes', 'Travelers', 'forms'),
('search_button', 'Explorar', 'Explore', 'forms'),
('nav_home', 'Início', 'Home', 'navigation'),
('nav_destinations', 'Destinos', 'Destinations', 'navigation'),
('nav_offers', 'Ofertas', 'Offers', 'navigation'),
('nav_testimonials', 'Depoimentos', 'Testimonials', 'navigation'),
('nav_contact', 'Contato', 'Contact', 'navigation'),
('login_button', 'Entrar', 'Login', 'navigation'),
('register_button', 'Cadastrar', 'Register', 'navigation'),
('stat_clients', 'Viajantes Felizes', 'Happy Travelers', 'stats'),
('stat_destinations', 'Destinos Únicos', 'Unique Destinations', 'stats'),
('stat_experience', 'Anos de Magia', 'Years of Magic', 'stats'),
('stat_support', 'Suporte Premium', 'Premium Support', 'stats');

-- Inserir Destinos
INSERT INTO destinations (name_pt, name_en, description_pt, description_en, price, discount, country_pt, country_en, duration_days, is_featured) VALUES
('Fernando de Noronha', 'Fernando de Noronha', 'Paraíso ecológico com praias de águas cristalinas e vida marinha exuberante. Experiência única de conexão com a natureza.', 'Ecological paradise with crystal clear waters beaches and exuberant marine life. Unique experience of connection with nature.', 3200.00, 15, 'Brasil', 'Brazil', 7, TRUE),
('Santorini', 'Santorini', 'Paisagens deslumbrantes, arquitetura única e pôr do sol inesquecível no mar Egeu. Romantismo puro.', 'Breathtaking landscapes, unique architecture and unforgettable sunset in the Aegean Sea. Pure romance.', 5800.00, 10, 'Grécia', 'Greece', 8, TRUE),
('Maldivas', 'Maldives', 'Bangalôs sobre as águas turquesa, areia branca e privacidade absoluta. O paraíso tropical definitivo.', 'Overwater bungalows on turquoise waters, white sand and absolute privacy. The definitive tropical paradise.', 8900.00, 20, 'Maldivas', 'Maldives', 10, TRUE),
('Kyoto', 'Kyoto', 'Tradição milenar, templos sagrados e jardins zen. Uma jornada espiritual pelo Japão feudal.', 'Millennial tradition, sacred temples and zen gardens. A spiritual journey through feudal Japan.', 4200.00, 5, 'Japão', 'Japan', 9, TRUE);

-- Inserir Ofertas Especiais
INSERT INTO special_offers (title_pt, title_en, description_pt, description_en, price, discount_percent, tag_pt, tag_en, start_date, end_date) VALUES
('Lua de Mel em Paris', 'Paris Honeymoon', '7 noites na cidade luz com jantar na Torre Eiffel, cruzeiro no Sena e tour romântico pelos pontos icônicos.', '7 nights in the city of light with dinner at the Eiffel Tower, Seine cruise and romantic tour of iconic spots.', 6200.00, 25, 'ROMÂNTICO', 'ROMANTIC', '2024-03-01', '2024-12-31'),
('Aventura na Patagônia', 'Patagonia Adventure', 'Trekking no Parque Torres del Paine, navegação entre glaciares e observação de pinguins. Para os aventureiros de alma.', 'Trekking in Torres del Paine Park, navigation between glaciers and penguin watching. For the adventurous souls.', 3800.00, 15, 'AVENTURA', 'ADVENTURE', '2024-02-15', '2024-11-30'),
('Caribe All Inclusive', 'Caribbean All Inclusive', '8 dias em resort premium com tudo incluso. Praias paradisíacas, gastronomia exclusiva e relaxamento total.', '8 days in premium all-inclusive resort. Paradise beaches, exclusive gastronomy and total relaxation.', 4500.00, 20, 'TUDO INCLUÍDO', 'ALL INCLUSIVE', '2024-01-10', '2024-10-15');

-- Inserir Depoimentos
INSERT INTO testimonials (client_name, testimonial_pt, testimonial_en, destination_pt, destination_en, rating) VALUES
('Ana e Rodrigo Silva', 'A SkyTravel transformou nossa lua de mel em algo mágico. Cada detalhe foi perfeito, desde a hospedagem até os passeios exclusivos. Superou todas as expectativas!', 'SkyTravel transformed our honeymoon into something magical. Every detail was perfect, from accommodation to exclusive tours. Exceeded all expectations!', 'Lua de Mel Maldivas', 'Maldives Honeymoon', 5),
('Carlos Mendes', 'Como viajante solo, encontrei na SkyTravel a segurança e confiança que precisava. A equipe foi incrível em criar um roteiro personalizado que atendeu todos meus interesses.', 'As a solo traveler, I found in SkyTravel the safety and trust I needed. The team was amazing in creating a personalized itinerary that met all my interests.', 'Expedição Japão', 'Japan Expedition', 5),
('Mariana Costa', 'Levei minha família e foi a melhor decisão. As crianças adoraram, tudo foi pensado para o conforto familiar. Já estamos planejando a próxima viagem com vocês!', 'I took my family and it was the best decision. The children loved it, everything was designed for family comfort. We are already planning our next trip with you!', 'Disney & Orlando', 'Disney & Orlando', 5);

-- Inserir Configurações
INSERT INTO site_settings (setting_key, setting_value, description) VALUES
('contact_phone', '+55 (11) 98765-4321', 'Telefone principal para contato'),
('contact_email', 'contato@skytravel.com', 'E-mail principal'),
('contact_whatsapp', '+5511987654321', 'WhatsApp para atendimento'),
('office_address', 'Av. Paulista, 1000 - São Paulo/SP', 'Endereço da sede'),
('business_hours', 'Segunda a Sexta: 9h às 18h', 'Horário de funcionamento'),
('social_facebook', 'skytravel.official', 'Facebook oficial'),
('social_instagram', '@skytravel', 'Instagram oficial');