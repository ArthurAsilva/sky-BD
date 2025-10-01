<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root"; // Altere conforme seu usuário MySQL
$password = ""; // Altere conforme sua senha MySQL
$dbname = "skytravel";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Definir idioma padrão
$lang = isset($_COOKIE['site_lang']) ? $_COOKIE['site_lang'] : 'pt';

// Definir tema padrão
$theme = isset($_COOKIE['site_theme']) ? $_COOKIE['site_theme'] : 'default';

// Processar mudança de idioma
if (isset($_POST['change_language'])) {
    $lang = $_POST['language'];
    setcookie('site_lang', $lang, time() + (86400 * 30), "/"); // 30 dias
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Processar mudança de tema
if (isset($_POST['change_theme'])) {
    $theme = $_POST['theme'];
    setcookie('site_theme', $theme, time() + (86400 * 30), "/"); // 30 dias
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Função para obter conteúdo traduzido
function getContent($key, $conn, $lang) {
    $sql = "SELECT content_pt, content_en FROM site_content WHERE content_key = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $key);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $lang == 'en' ? $row['content_en'] : $row['content_pt'];
    }
    return "[Content not found: $key]";
}

// Buscar destinos
$destinations = [];
$sql = "SELECT name_pt, name_en, description_pt, description_en, price, discount FROM destinations WHERE is_active = 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $destinations[] = $row;
    }
}

// Buscar ofertas especiais
$offers = [];
$sql = "SELECT title_pt, title_en, description_pt, description_en, price, discount_percent, tag_pt, tag_en FROM special_offers WHERE is_active = 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $offers[] = $row;
    }
}

// Buscar depoimentos
$testimonials = [];
$sql = "SELECT client_name, testimonial_pt, testimonial_en, destination_pt, destination_en, rating FROM testimonials WHERE is_active = 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $testimonials[] = $row;
    }
}

// Buscar estatísticas
$stats = [
    'clients' => 15000,
    'destinations' => 50,
    'experience' => 12,
    'support' => '24/7'
];

// Buscar configurações de contato
$contact_phone = '(11) 3456-7890';
$contact_email = 'contato@skytravel.com';
$sql = "SELECT setting_value FROM site_settings WHERE setting_key IN ('contact_phone', 'contact_email')";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Esta parte precisaria ser ajustada dependendo da estrutura exata da tabela
    }
}
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkyTravel - <?php echo $lang == 'en' ? 'Your Travel Agency' : 'Sua Agência de Viagens'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-dark: #1a1a2e;
            --secondary-dark: #16213e;
            --lavender: #e2e2f7;
            --lavender-light: #f8f8ff;
            --lavender-accent: #c7b9f7;
            --blue-light: #a3d5ff;
            --blue-medium: #64b5f6;
            --blue-dark: #1e88e5;
            --purple: #9c27b0;
            --purple-light: #ce93d8;
            --gradient-1: linear-gradient(135deg, #c7b9f7, #a3d5ff);
            --gradient-2: linear-gradient(135deg, #64b5f6, #9c27b0);
            --gradient-3: linear-gradient(135deg, #e2e2f7, #64b5f6);
            --card-bg: rgba(255, 255, 255, 0.95);
            --text-dark: #333;
            --text-light: #666;
            --border-radius: 15px;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        /* Tema Azul */
        .theme-blue {
            --primary-dark: #0a2463;
            --secondary-dark: #1e3d72;
            --lavender: #d6e4ff;
            --lavender-light: #f0f5ff;
            --lavender-accent: #a3c4ff;
            --blue-light: #7fb2ff;
            --blue-medium: #3d85f6;
            --blue-dark: #0d47a1;
            --purple: #1565c0;
            --purple-light: #64b5f6;
            --gradient-1: linear-gradient(135deg, #a3c4ff, #7fb2ff);
            --gradient-2: linear-gradient(135deg, #3d85f6, #1565c0);
            --gradient-3: linear-gradient(135deg, #d6e4ff, #3d85f6);
        }

        /* Tema Roxo */
        .theme-purple {
            --primary-dark: #311b92;
            --secondary-dark: #4527a0;
            --lavender: #e8eaf6;
            --lavender-light: #f3e5f5;
            --lavender-accent: #c5cae9;
            --blue-light: #b39ddb;
            --blue-medium: #7e57c2;
            --blue-dark: #5e35b1;
            --purple: #8e24aa;
            --purple-light: #ba68c8;
            --gradient-1: linear-gradient(135deg, #c5cae9, #b39ddb);
            --gradient-2: linear-gradient(135deg, #7e57c2, #8e24aa);
            --gradient-3: linear-gradient(135deg, #e8eaf6, #7e57c2);
        }

        body {
            background: linear-gradient(135deg, var(--primary-dark), var(--secondary-dark));
            color: var(--text-dark);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 15% 25%, rgba(199, 185, 247, 0.1) 0%, transparent 25%),
                radial-gradient(circle at 85% 15%, rgba(163, 213, 255, 0.1) 0%, transparent 25%),
                var(--primary-dark);
            z-index: -1;
        }

        .splash-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-dark), var(--secondary-dark));
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            transition: all 1.2s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .splash-screen.fade-out {
            opacity: 0;
            visibility: hidden;
        }

        .logo-splash {
            font-size: 3rem;
            font-weight: 700;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 2rem;
            text-shadow: 0 0 20px rgba(199, 185, 247, 0.3);
        }

        .plane-animation {
            width: 100px;
            height: 60px;
            position: relative;
            margin-bottom: 2rem;
        }

        .plane {
            position: absolute;
            width: 100px;
            height: 30px;
            background: var(--gradient-1);
            border-radius: 50% 50% 0 0;
            animation: fly 3s infinite;
        }

        .plane::before {
            content: '';
            position: absolute;
            top: -15px;
            left: 20px;
            width: 60px;
            height: 20px;
            background: var(--gradient-1);
            border-radius: 50% 50% 0 0;
        }

        .plane::after {
            content: '';
            position: absolute;
            top: 10px;
            left: -20px;
            width: 40px;
            height: 10px;
            background: var(--gradient-1);
            border-radius: 50% 0 0 50%;
        }

        @keyframes fly {
            0% { transform: translateX(-100px); }
            100% { transform: translateX(400px); }
        }

        .splash-text {
            color: var(--lavender-light);
            font-size: 1.8rem;
            font-weight: 300;
            letter-spacing: 3px;
            text-align: center;
        }

        .loading-dots::after {
            content: '.';
            animation: dots 1.5s infinite;
        }

        @keyframes dots {
            0%, 20% { content: '.'; }
            40% { content: '..'; }
            60%, 100% { content: '...'; }
        }

        .main-content {
            opacity: 0;
            transition: opacity 1s ease-in;
        }

        header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid rgba(199, 185, 247, 0.3);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 2rem;
            font-weight: 700;
            background: var(--gradient-2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        nav a {
            color: var(--text-dark);
            text-decoration: none;
            transition: var(--transition);
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            position: relative;
            overflow: hidden;
        }

        nav a:hover {
            color: var(--blue-dark);
            background: rgba(199, 185, 247, 0.2);
        }

        nav a.active {
            background: var(--gradient-1);
            color: var(--primary-dark);
        }

        .auth-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.8rem 1.5rem;
            border-radius: 25px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-block;
            font-size: 0.9rem;
        }

        .btn-primary {
            background: var(--gradient-2);
            color: white;
            box-shadow: 0 5px 15px rgba(100, 181, 246, 0.3);
        }

        .btn-secondary {
            background: transparent;
            color: var(--blue-dark);
            border: 2px solid var(--blue-dark);
        }

        .btn-admin {
            background: linear-gradient(135deg, #ff6b6b, #c0392b);
            color: white;
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(100, 181, 246, 0.4);
        }

        .btn-admin:hover {
            box-shadow: 0 10px 25px rgba(255, 107, 107, 0.4);
        }

        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: 
                linear-gradient(rgba(26, 26, 46, 0.8), rgba(22, 33, 62, 0.9)),
                url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><rect width="200" height="200" fill="%231a1a2e"/><path d="M0,100 Q50,80 100,100 T200,100 L200,200 L0,200 Z" fill="%2316213e" opacity="0.7"/><circle cx="40" cy="80" r="5" fill="%23c7b9f7" opacity="0.6"/><circle cx="160" cy="120" r="3" fill="%23a3d5ff" opacity="0.6"/></svg>');
            background-size: cover;
            position: relative;
            overflow: hidden;
            margin-top: 80px;
        }

        .hero-content {
            max-width: 800px;
            padding: 0 2rem;
            z-index: 2;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-content p {
            font-size: 1.2rem;
            color: var(--lavender-light);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .search-box {
            background: var(--card-bg);
            padding: 1.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            margin-top: 2rem;
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
        }

        .search-input {
            flex: 1;
            min-width: 200px;
            padding: 1rem;
            border-radius: 8px;
            border: 2px solid rgba(199, 185, 247, 0.3);
            background: rgba(255, 255, 255, 0.8);
        }

        .section {
            padding: 5rem 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            position: relative;
            color: var(--text-dark);
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--gradient-2);
            border-radius: 2px;
        }

        .card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 2rem;
            box-shadow: var(--shadow);
            transition: var(--transition);
            border: 1px solid rgba(199, 185, 247, 0.2);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            border-color: var(--lavender-accent);
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .dashboard-card {
            background: var(--card-bg);
            padding: 2rem;
            border-radius: var(--border-radius);
            text-align: center;
            box-shadow: var(--shadow);
            transition: var(--transition);
            border: 1px solid rgba(199, 185, 247, 0.2);
            cursor: pointer;
        }

        .dashboard-card:hover {
            transform: translateY(-10px);
            border-color: var(--lavender-accent);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .dashboard-card i {
            font-size: 3rem;
            color: var(--blue-dark);
            margin-bottom: 1.5rem;
            background: var(--gradient-3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .dashboard-card h3 {
            font-size: 1.4rem;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }

        .dashboard-card p {
            color: var(--text-light);
            line-height: 1.6;
        }

        .price {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--blue-dark);
            margin-top: 1rem;
        }

        .discount {
            color: #e74c3c;
            font-weight: 600;
            display: block;
            margin-top: 0.5rem;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background: var(--card-bg);
            padding: 2.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            border: 1px solid rgba(199, 185, 247, 0.2);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
            font-weight: 500;
        }

        .form-group input, 
        .form-group select, 
        .form-group textarea {
            width: 100%;
            padding: 1rem;
            border-radius: 8px;
            border: 2px solid rgba(199, 185, 247, 0.3);
            background: rgba(255, 255, 255, 0.8);
            color: var(--text-dark);
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-group input:focus, 
        .form-group select:focus, 
        .form-group textarea:focus {
            outline: none;
            border-color: var(--blue-medium);
            box-shadow: 0 0 0 3px rgba(100, 181, 246, 0.2);
        }

        .form-footer {
            text-align: center;
            margin-top: 2rem;
            color: var(--text-light);
        }

        .form-footer a {
            color: var(--blue-dark);
            text-decoration: none;
            font-weight: 500;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        .table-container {
            overflow-x: auto;
            background: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            border: 1px solid rgba(199, 185, 247, 0.2);
            margin-top: 2rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid rgba(199, 185, 247, 0.2);
        }

        th {
            background: rgba(199, 185, 247, 0.1);
            font-weight: 600;
            color: var(--text-dark);
        }

        tr:hover {
            background: rgba(199, 185, 247, 0.05);
        }

        .status {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status.active {
            background: rgba(100, 181, 246, 0.2);
            color: var(--blue-dark);
        }

        .status.inactive {
            background: rgba(156, 39, 176, 0.2);
            color: var(--purple);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: var(--card-bg);
            padding: 1.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            border: 1px solid rgba(199, 185, 247, 0.2);
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--blue-dark);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .search-bar {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .search-bar input, .search-bar select {
            flex: 1;
            min-width: 150px;
            padding: 1rem;
            border-radius: 8px;
            border: 2px solid rgba(199, 185, 247, 0.3);
            background: rgba(255, 255, 255, 0.8);
        }

        .search-bar button {
            align-self: flex-end;
        }

        footer {
            background: rgba(255, 255, 255, 0.95);
            padding: 3rem 2rem 2rem;
            border-top: 1px solid rgba(199, 185, 247, 0.3);
        }

        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            text-align: center;
        }

        .footer-content .logo {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            justify-content: center;
        }

        .footer-content p {
            color: var(--text-light);
            margin-bottom: 0.5rem;
            line-height: 1.6;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--gradient-1);
            color: white;
            text-decoration: none;
            transition: var(--transition);
        }

        .social-links a:hover {
            transform: translateY(-3px);
        }

        .copyright {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(199, 185, 247, 0.3);
            color: var(--text-light);
            font-size: 0.9rem;
        }

        @media (max-width: 992px) {
            .hero-content h1 {
                font-size: 2.8rem;
            }
            
            nav ul {
                gap: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }
            
            nav ul {
                flex-wrap: wrap;
                justify-content: center;
                gap: 0.8rem;
            }
            
            .hero-content h1 {
                font-size: 2.3rem;
            }
            
            .hero {
                margin-top: 120px;
            }
            
            .section {
                padding: 3rem 1rem;
            }
            
            .auth-buttons {
                width: 100%;
                justify-content: center;
            }
            
            .search-bar {
                flex-direction: column;
            }
            
            .search-bar input, .search-bar select, .search-bar button {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .hero-content h1 {
                font-size: 2rem;
            }
            
            .form-container {
                padding: 1.5rem;
            }
            
            .btn {
                width: 100%;
                text-align: center;
            }
            
            nav ul {
                gap: 0.5rem;
            }
            
            nav a {
                padding: 0.3rem 0.6rem;
                font-size: 0.9rem;
            }
        }

        .hidden {
            display: none !important;
        }

        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }

        @keyframes fadeIn {
            from { 
                opacity: 0; 
                transform: translateY(20px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }

        .modal.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background: var(--card-bg);
            padding: 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            max-width: 500px;
            width: 90%;
            position: relative;
            transform: translateY(-20px);
            transition: var(--transition);
            max-height: 80vh;
            overflow-y: auto;
        }

        .modal.active .modal-content {
            transform: translateY(0);
        }

        .close-modal {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-light);
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            text-align: center;
        }

        .alert-success {
            background: rgba(100, 181, 246, 0.2);
            color: var(--blue-dark);
            border: 1px solid var(--blue-medium);
        }

        .alert-error {
            background: rgba(244, 67, 54, 0.2);
            color: #f44336;
            border: 1px solid #f44336;
        }

        .two-column {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        @media (max-width: 768px) {
            .two-column {
                grid-template-columns: 1fr;
            }
        }

        .testimonials {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .testimonial {
            background: var(--card-bg);
            padding: 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            border: 1px solid rgba(199, 185, 247, 0.2);
        }

        .testimonial-text {
            font-style: italic;
            color: var(--text-light);
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .author-info h4 {
            margin: 0;
            color: var(--text-dark);
        }

        .author-info p {
            margin: 0;
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .offers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .offer-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .offer-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .offer-image {
            height: 200px;
            background: var(--gradient-1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }

        .offer-content {
            padding: 1.5rem;
        }

        .offer-tag {
            display: inline-block;
            background: #e74c3c;
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            margin-bottom: 1rem;
        }

        .control-panel {
            position: fixed;
            top: 50%;
            right: 0;
            transform: translateY(-50%);
            background: var(--card-bg);
            padding: 1rem;
            border-radius: 10px 0 0 10px;
            box-shadow: -5px 5px 15px rgba(0, 0, 0, 0.1);
            z-index: 99;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .control-btn {
            background: var(--gradient-2);
            color: white;
            border: none;
            border-radius: 5px;
            padding: 0.5rem 1rem;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.8rem;
            white-space: nowrap;
        }

        .admin-section {
            display: none;
            padding: 2rem;
            background: var(--card-bg);
            border-radius: var(--border-radius);
            margin: 2rem 0;
            box-shadow: var(--shadow);
        }

        .admin-section.active {
            display: block;
        }

        .admin-controls {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .admin-control {
            background: rgba(199, 185, 247, 0.1);
            padding: 1rem;
            border-radius: var(--border-radius);
            border: 1px solid rgba(199, 185, 247, 0.2);
        }

        .tab-container {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .tab {
            padding: 0.8rem 1.5rem;
            background: rgba(199, 185, 247, 0.2);
            border-radius: 25px;
            cursor: pointer;
            transition: var(--transition);
        }

        .tab.active {
            background: var(--gradient-1);
            color: var(--primary-dark);
            font-weight: 600;
        }

        .page-section {
            display: none;
        }

        .page-section.active {
            display: block;
            animation: fadeIn 0.5s ease-in;
        }
    </style>
</head>
<body class="<?php echo $theme; ?>">
    <!-- Splash Screen -->
    <div class="splash-screen">
        <div class="plane-animation">
            <div class="plane"></div>
        </div>
        <div class="logo-splash">SkyTravel</div>
        <div class="splash-text">
            <?php echo $lang == 'en' ? 'Preparing your next trip' : 'Preparando sua próxima viagem'; ?>
            <span class="loading-dots"></span>
        </div>
    </div>

    <!-- Painel de Controle (Idioma e Tema) -->
    <div class="control-panel">
        <form method="post" class="control-form">
            <select name="language" class="control-btn" onchange="this.form.submit()">
                <option value="pt" <?php echo $lang == 'pt' ? 'selected' : ''; ?>>PT</option>
                <option value="en" <?php echo $lang == 'en' ? 'selected' : ''; ?>>EN</option>
            </select>
            <input type="hidden" name="change_language" value="1">
        </form>
        
        <form method="post" class="control-form">
            <select name="theme" class="control-btn" onchange="this.form.submit()">
                <option value="default" <?php echo $theme == 'default' ? 'selected' : ''; ?>><?php echo $lang == 'en' ? 'Default' : 'Padrão'; ?></option>
                <option value="theme-blue" <?php echo $theme == 'theme-blue' ? 'selected' : ''; ?>><?php echo $lang == 'en' ? 'Blue' : 'Azul'; ?></option>
                <option value="theme-purple" <?php echo $theme == 'theme-purple' ? 'selected' : ''; ?>><?php echo $lang == 'en' ? 'Purple' : 'Roxo'; ?></option>
            </select>
            <input type="hidden" name="change_theme" value="1">
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <header>
            <div class="header-content">
                <div class="logo">
                    <i class="fas fa-plane"></i> SkyTravel
                </div>
                <nav>
                    <ul>
                        <li><a href="#" class="nav-link active" data-section="home"><?php echo getContent('nav_home', $conn, $lang); ?></a></li>
                        <li><a href="#" class="nav-link" data-section="destinations"><?php echo getContent('nav_destinations', $conn, $lang); ?></a></li>
                        <li><a href="#" class="nav-link" data-section="offers"><?php echo getContent('nav_offers', $conn, $lang); ?></a></li>
                        <li><a href="#" class="nav-link" data-section="testimonials"><?php echo getContent('nav_testimonials', $conn, $lang); ?></a></li>
                        <li><a href="#" class="nav-link" data-section="contact"><?php echo getContent('nav_contact', $conn, $lang); ?></a></li>
                    </ul>
                </nav>
                <div class="auth-buttons">
                    <a href="#" class="btn btn-secondary"><?php echo getContent('login_button', $conn, $lang); ?></a>
                    <a href="#" class="btn btn-primary"><?php echo getContent('register_button', $conn, $lang); ?></a>
                </div>
            </div>
        </header>

        <!-- Home Section -->
        <section class="page-section active" id="home">
            <!-- Hero Section -->
            <div class="hero">
                <div class="hero-content">
                    <h1 id="heroTitle"><?php echo getContent('main_title', $conn, $lang); ?></h1>
                    <p id="heroSubtitle"><?php echo getContent('main_subtitle', $conn, $lang); ?></p>
                    <a href="#" class="btn btn-primary" id="heroButton"><?php echo getContent('main_button', $conn, $lang); ?></a>
                    
                    <div class="search-box">
                        <input type="text" class="search-input" placeholder="<?php echo getContent('search_placeholder', $conn, $lang); ?>">
                        <input type="date" class="search-input">
                        <input type="date" class="search-input">
                        <select class="search-input">
                            <option>1 <?php echo getContent('travelers_label', $conn, $lang); ?></option>
                            <option>2 <?php echo getContent('travelers_label', $conn, $lang); ?></option>
                            <option>3 <?php echo getContent('travelers_label', $conn, $lang); ?></option>
                            <option>4+ <?php echo getContent('travelers_label', $conn, $lang); ?></option>
                        </select>
                        <button class="btn btn-primary"><?php echo getContent('search_button', $conn, $lang); ?></button>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="section">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number">15,000+</div>
                        <div class="stat-label"><?php echo getContent('stat_clients', $conn, $lang); ?></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">50+</div>
                        <div class="stat-label"><?php echo getContent('stat_destinations', $conn, $lang); ?></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">12</div>
                        <div class="stat-label"><?php echo getContent('stat_experience', $conn, $lang); ?></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label"><?php echo getContent('stat_support', $conn, $lang); ?></div>
                    </div>
                </div>
            </div>

            <!-- Destinations Section -->
            <div class="section">
                <h2 class="section-title"><?php echo getContent('section_destinations', $conn, $lang); ?></h2>
                <div class="dashboard-grid">
                    <?php foreach($destinations as $index => $destination): ?>
                    <div class="dashboard-card">
                        <i class="fas fa-umbrella-beach"></i>
                        <h3><?php echo $lang == 'en' ? $destination['name_en'] : $destination['name_pt']; ?></h3>
                        <p><?php echo $lang == 'en' ? $destination['description_en'] : $destination['description_pt']; ?></p>
                        <div class="price"><?php echo $lang == 'en' ? 'From ' : 'A partir de '; ?> R$ <?php echo number_format($destination['price'], 2, ',', '.'); ?></div>
                        <?php if($destination['discount'] > 0): ?>
                        <span class="discount"><?php echo $destination['discount']; ?>% <?php echo $lang == 'en' ? 'off for early bookings' : 'off para reservas antecipadas'; ?></span>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Special Offers -->
            <div class="section">
                <h2 class="section-title"><?php echo getContent('section_offers', $conn, $lang); ?></h2>
                <div class="offers-grid">
                    <?php foreach($offers as $index => $offer): ?>
                    <div class="offer-card">
                        <div class="offer-image">
                            <i class="fas fa-sun"></i>
                        </div>
                        <div class="offer-content">
                            <span class="offer-tag"><?php echo $lang == 'en' ? $offer['tag_en'] : $offer['tag_pt']; ?></span>
                            <h3><?php echo $lang == 'en' ? $offer['title_en'] : $offer['title_pt']; ?></h3>
                            <p><?php echo $lang == 'en' ? $offer['description_en'] : $offer['description_pt']; ?></p>
                            <div class="price">R$ <?php echo number_format($offer['price'], 2, ',', '.'); ?></div>
                            <a href="#" class="btn btn-primary"><?php echo $lang == 'en' ? 'Book Now' : 'Reservar Agora'; ?></a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Testimonials -->
            <div class="section">
                <h2 class="section-title"><?php echo getContent('section_testimonials', $conn, $lang); ?></h2>
                <div class="testimonials">
                    <?php foreach($testimonials as $index => $testimonial): ?>
                    <div class="testimonial">
                        <div class="testimonial-text">
                            <?php echo $lang == 'en' ? $testimonial['testimonial_en'] : $testimonial['testimonial_pt']; ?>
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar" style="background: var(--gradient-<?php echo $index + 1; ?>);"></div>
                            <div class="author-info">
                                <h4><?php echo $testimonial['client_name']; ?></h4>
                                <p><?php echo $lang == 'en' ? $testimonial['destination_en'] : $testimonial['destination_pt']; ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="page-section" id="contact">
            <div class="section" style="padding-top: 150px;">
                <h2 class="section-title"><?php echo getContent('section_contact', $conn, $lang); ?></h2>
                <div class="form-container">
                    <form id="contactForm">
                        <div class="form-group">
                            <label for="name"><?php echo getContent('name_label', $conn, $lang); ?></label>
                            <input type="text" id="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email"><?php echo getContent('email_label', $conn, $lang); ?></label>
                            <input type="email" id="email" required>
                        </div>
                        <div class="form-group">
                            <label for="message"><?php echo getContent('message_label', $conn, $lang); ?></label>
                            <textarea id="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary"><?php echo getContent('send_button', $conn, $lang); ?></button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer>
            <div class="footer-content">
                <div class="logo">
                    <i class="fas fa-plane"></i> SkyTravel
                </div>
                <p><?php echo getContent('footer_text', $conn, $lang); ?></p>
                <p><?php echo $lang == 'en' ? 'Contact:' : 'Contato:'; ?> <?php echo $contact_phone; ?> | <?php echo $contact_email; ?></p>
                
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
                
                <div class="copyright">
                    <?php echo getContent('copyright', $conn, $lang); ?>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Splash screen
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.querySelector('.splash-screen').classList.add('fade-out');
                document.querySelector('.main-content').style.opacity = '1';
            }, 3000);
        });

        // Navigation
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all links
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                
                // Add active class to clicked link
                this.classList.add('active');
                
                // Hide all sections
                document.querySelectorAll('.page-section').forEach(section => {
                    section.classList.remove('active');
                });
                
                // Show the selected section
                const sectionId = this.getAttribute('data-section');
                document.getElementById(sectionId).classList.add('active');
                
                // Scroll to top
                window.scrollTo(0, 0);
            });
        });

        // Contact form
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('<?php echo $lang == 'en' ? 'Message sent successfully! We will contact you soon.' : 'Mensagem enviada com sucesso! Em breve entraremos em contato.'; ?>');
            this.reset();
        });
    </script>
</body>
</html>
<?php
// Fechar conexão
$conn->close();
?>