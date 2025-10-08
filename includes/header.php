<!DOCTYPE html>
<html lang="<?php echo $_SESSION['idioma'] == 'pt' ? 'pt-BR' : 'en'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo t('titulo_site'); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Aurora Background Effect -->
    <div class="aurora-effect" id="auroraEffect"></div>
    
    <!-- Header -->
    <header id="mainHeader">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <i class="fas fa-mountain"></i>
                    Cleste Aviation
                </div>
                <nav>
                    <ul>
                        <li><a href="#inicio"><?php echo t('menu_inicio'); ?></a></li>
                        <li><a href="#destinos"><?php echo t('menu_destinos'); ?></a></li>
                        <li><a href="#pacotes"><?php echo t('menu_pacotes'); ?></a></li>
                        <li><a href="#sobre"><?php echo t('menu_sobre'); ?></a></li>
                        <li><a href="#contato"><?php echo t('menu_contato'); ?></a></li>
                        <li><a href="?trocar_idioma=1" class="idioma-link">
                            <i class="fas fa-globe"></i>
                            <?php echo t('trocar_idioma'); ?>
                        </a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>