<?php
session_start();

// Configurações do site
define('SITE_NAME', 'Cleste Aviation');
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']));

// Idioma padrão
if (!isset($_SESSION['idioma'])) {
    $_SESSION['idioma'] = 'pt';
}

// Alternar idioma
if (isset($_GET['trocar_idioma'])) {
    $_SESSION['idioma'] = ($_SESSION['idioma'] == 'pt') ? 'en' : 'pt';
    $url = str_replace('?trocar_idioma=1', '', $_SERVER['REQUEST_URI']);
    header('Location: ' . $url);
    exit;
}

// Incluir database
require_once 'database.php';
$database = new Database();
$db = $database->getConnection();

// Não mostrar erro se não conectar - usaremos fallback
// Função de tradução
function t($chave) {
    $traducoes = [
        'pt' => [
            'titulo_site' => 'Cleste Aviation - Viagens Aurora Boreal',
            'menu_inicio' => 'Início',
            'menu_destinos' => 'Destinos',
            'menu_pacotes' => 'Pacotes',
            'menu_sobre' => 'Sobre Nós',
            'menu_contato' => 'Contato',
            'hero_titulo' => 'Explore o Esplendor da Aurora Boreal',
            'hero_subtitulo' => 'Viagens exclusivas para os melhores destinos do mundo para observar as luzes do norte',
            'hero_botao' => 'Descobrir Pacotes',
            'destaques_titulo' => 'Destinos em Destaque',
            'sobre_titulo' => 'Sobre a Cleste Aviation',
            'sobre_texto' => 'Há mais de 15 anos proporcionamos experiências únicas de observação da Aurora Boreal. Nossa equipe de especialistas seleciona os melhores destinos e momentos para garantir que você tenha a experiência mais memorável.',
            'pacotes_titulo' => 'Nossos Pacotes',
            'depoimentos_titulo' => 'O que nossos clientes dizem',
            'contato_titulo' => 'Entre em Contato',
            'contato_nome' => 'Seu Nome',
            'contato_email' => 'Seu E-mail',
            'contato_telefone' => 'Seu Telefone',
            'contato_mensagem' => 'Sua Mensagem',
            'contato_enviar' => 'Enviar Mensagem',
            'newsletter_titulo' => 'Receba Nossas Ofertas',
            'newsletter_placeholder' => 'Seu melhor e-mail',
            'newsletter_botao' => 'Inscrever',
            'rodape_texto' => 'Cleste Aviation - Sua jornada para as luzes do norte começa aqui.',
            'trocar_idioma' => 'English',
            'direitos' => 'Todos os direitos reservados.'
        ],
        'en' => [
            'titulo_site' => 'Cleste Aviation - Aurora Borealis Travel',
            'menu_inicio' => 'Home',
            'menu_destinos' => 'Destinations',
            'menu_pacotes' => 'Packages',
            'menu_sobre' => 'About Us',
            'menu_contato' => 'Contact',
            'hero_titulo' => 'Explore the Splendor of the Aurora Borealis',
            'hero_subtitulo' => 'Exclusive trips to the world\'s best destinations to observe the northern lights',
            'hero_botao' => 'Discover Packages',
            'destaques_titulo' => 'Featured Destinations',
            'sobre_titulo' => 'About Cleste Aviation',
            'sobre_texto' => 'For over 15 years we have provided unique Aurora Borealis viewing experiences. Our team of experts selects the best destinations and times to ensure you have the most memorable experience.',
            'pacotes_titulo' => 'Our Packages',
            'depoimentos_titulo' => 'What Our Customers Say',
            'contato_titulo' => 'Get In Touch',
            'contato_nome' => 'Your Name',
            'contato_email' => 'Your Email',
            'contato_telefone' => 'Your Phone',
            'contato_mensagem' => 'Your Message',
            'contato_enviar' => 'Send Message',
            'newsletter_titulo' => 'Get Our Offers',
            'newsletter_placeholder' => 'Your best email',
            'newsletter_botao' => 'Subscribe',
            'rodape_texto' => 'Cleste Aviation - Your journey to the northern lights starts here.',
            'trocar_idioma' => 'Português',
            'direitos' => 'All rights reserved.'
        ]
    ];
    
    $idioma = $_SESSION['idioma'];
    return isset($traducoes[$idioma][$chave]) ? $traducoes[$idioma][$chave] : $chave;
}

// Função para buscar dados do banco com fallback
function getFromDB($table, $limit = null) {
    global $db;
    
    if (!$db) {
        return []; // Retorna array vazio se não houver conexão
    }
    
    try {
        $query = "SELECT * FROM $table WHERE ativo = TRUE ORDER BY id";
        if ($limit) {
            $query .= " LIMIT $limit";
        }
        
        $stmt = $db->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Em caso de erro, retorna array vazio
        return [];
    }
}
?>