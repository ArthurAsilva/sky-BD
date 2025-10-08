<?php
require_once 'config/config.php';
?>

<?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero" id="inicio">
    <div class="floating-elements">
            <div class="floating-element" style="top: 20%; left: 10%; animation-delay: 0s;"></div>
            <div class="floating-element" style="top: 60%; right: 10%; animation-delay: 1s;"></div>
            <div class="floating-element" style="bottom: 30%; left: 20%; animation-delay: 2s;"></div>
        </div>
    </section>

    <!-- Destinos em Destaque -->
    <section id="destinos">
        <div class="container">
            <h2 class="section-title"><?php echo t('destaques_titulo'); ?></h2>
            <div class="destaques-grid">
                <?php
                // Buscar destinos do banco de dados com fallback
                $destinos = getFromDB('destinos', 4);
                
                // Se não houver destinos no banco, usar dados padrão
                if (empty($destinos)) {
                    $destinos = [
                        [
                            'nome_pt' => 'Noruega', 
                            'nome_en' => 'Norway',
                            'descricao_pt' => 'Tromsø - A capital do Ártico',
                            'descricao_en' => 'Tromsø - The Arctic Capital',
                            'imagem' => 'https://source.unsplash.com/600x400/?norway,aurora'
                        ],
                        [
                            'nome_pt' => 'Islândia', 
                            'nome_en' => 'Iceland',
                            'descricao_pt' => 'Reiquejavique - Fogo e Gelo',
                            'descricao_en' => 'Reykjavik - Fire and Ice',
                            'imagem' => 'https://source.unsplash.com/600x400/?iceland,aurora'
                        ],
                        [
                            'nome_pt' => 'Finlândia', 
                            'nome_en' => 'Finland',
                            'descricao_pt' => 'Rovaniemi - Terra do Papai Noel',
                            'descricao_en' => 'Rovaniemi - Santa\'s Homeland',
                            'imagem' => 'https://source.unsplash.com/600x400/?finland,aurora'
                        ],
                        [
                            'nome_pt' => 'Canadá', 
                            'nome_en' => 'Canada',
                            'descricao_pt' => 'Yellowknife - Céus Deslumbrantes',
                            'descricao_en' => 'Yellowknife - Dazzling Skies',
                            'imagem' => 'https://source.unsplash.com/600x400/?canada,aurora'
                        ]
                    ];
                }
                
                foreach ($destinos as $row) {
                    $nome = $_SESSION['idioma'] == 'pt' ? $row['nome_pt'] : $row['nome_en'];
                    $descricao = $_SESSION['idioma'] == 'pt' ? $row['descricao_pt'] : $row['descricao_en'];
                    $imagem = isset($row['imagem']) && $row['imagem'] ? $row['imagem'] : 'https://source.unsplash.com/600x400/?' . urlencode($nome);
                    
                    echo "
                    <div class='destaque-card'>
                        <div class='destaque-img' style='background-image: url(\"$imagem\")'></div>
                        <div class='destaque-content'>
                            <h3>$nome</h3>
                            <p>$descricao</p>
                        </div>
                    </div>";
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Sobre Nós -->
    <section class="sobre" id="sobre">
        <div class="container">
            <h2 class="section-title"><?php echo t('sobre_titulo'); ?></h2>
            <div class="sobre-content">
                <div class="sobre-texto">
                    <p><?php echo t('sobre_texto'); ?></p>
                </div>
                <div class="sobre-imagem" style="background-image: url('https://source.unsplash.com/600x400/?travel,agency')"></div>
            </div>
        </div>
    </section>
    <div class="sobre-stats">
                    <div class="stat">
                        <span class="stat-number">15+</span>
                        <span class="stat-label"><?php echo $_SESSION['idioma'] == 'pt' ? 'Anos de Experiência' : 'Years Experience'; ?></span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">5000+</span>
                        <span class="stat-label"><?php echo $_SESSION['idioma'] == 'pt' ? 'Clientes Satisfeitos' : 'Happy Clients'; ?></span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">12</span>
                        <span class="stat-label"><?php echo $_SESSION['idioma'] == 'pt' ? 'Destinos Únicos' : 'Unique Destinations'; ?></span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">98%</span>
                        <span class="stat-label"><?php echo $_SESSION['idioma'] == 'pt' ? 'Taxa de Sucesso' : 'Success Rate'; ?></span>
                    </div>
                </div>

    <!-- Pacotes -->
    <section id="pacotes">
        <div class="container">
            <h2 class="section-title"><?php echo t('pacotes_titulo'); ?></h2>
            <div class="pacotes-grid">
                <?php
                // Buscar pacotes do banco de dados com fallback
                $pacotes = getFromDB('pacotes', 3);
                
                // Se não houver pacotes no banco, usar dados padrão
                if (empty($pacotes)) {
                    $pacotes = [
                        [
                            'nome_pt' => 'Expedição Ártica',
                            'nome_en' => 'Arctic Expedition',
                            'descricao_pt' => 'Uma aventura única pelo Ártico',
                            'descricao_en' => 'A unique Arctic adventure',
                            'preco_pt' => 'A partir de R$ 5.999',
                            'preco_en' => 'From $1,199',
                            'duracao_pt' => '5 noites',
                            'duracao_en' => '5 nights',
                            'imagem' => 'https://source.unsplash.com/600x400/?arctic,expedition'
                        ],
                        [
                            'nome_pt' => 'Aurora Premium',
                            'nome_en' => 'Premium Aurora',
                            'descricao_pt' => 'Experiência premium para ver a Aurora',
                            'descricao_en' => 'Premium Aurora viewing experience',
                            'preco_pt' => 'A partir de R$ 7.499',
                            'preco_en' => 'From $1,499',
                            'duracao_pt' => '7 noites',
                            'duracao_en' => '7 nights',
                            'imagem' => 'https://source.unsplash.com/600x400/?premium,travel'
                        ],
                        [
                            'nome_pt' => 'Viagem dos Sonhos',
                            'nome_en' => 'Dream Journey',
                            'descricao_pt' => 'A viagem dos seus sonhos pelas terras do norte',
                            'descricao_en' => 'Your dream journey through northern lands',
                            'preco_pt' => 'A partir de R$ 9.999',
                            'preco_en' => 'From $1,999',
                            'duracao_pt' => '10 noites',
                            'duracao_en' => '10 nights',
                            'imagem' => 'https://source.unsplash.com/600x400/?dream,travel'
                        ]
                    ];
                }
                
                foreach ($pacotes as $row) {
                    $nome = $_SESSION['idioma'] == 'pt' ? $row['nome_pt'] : $row['nome_en'];
                    $descricao = $_SESSION['idioma'] == 'pt' ? $row['descricao_pt'] : $row['descricao_en'];
                    $preco = $_SESSION['idioma'] == 'pt' ? $row['preco_pt'] : $row['preco_en'];
                    $duracao = $_SESSION['idioma'] == 'pt' ? $row['duracao_pt'] : $row['duracao_en'];
                    $imagem = isset($row['imagem']) && $row['imagem'] ? $row['imagem'] : 'https://source.unsplash.com/600x400/?travel,package';
                    
                    echo "
                    <div class='pacote-card'>
                        <div class='pacote-header'>
                            <h3>$nome</h3>
                        </div>
                        <div class='pacote-body'>
                            <div class='pacote-preco'>$preco</div>
                            <p>$descricao</p>
                            <ul class='pacote-lista'>
                                <li>$duracao</li>
                                <li>".($_SESSION['idioma'] == 'pt' ? 'Hospedagem inclusa' : 'Accommodation included')."</li>
                                <li>".($_SESSION['idioma'] == 'pt' ? 'Guias especializados' : 'Expert guides')."</li>
                                <li>".($_SESSION['idioma'] == 'pt' ? 'Transporte' : 'Transportation')."</li>
                                <li>".($_SESSION['idioma'] == 'pt' ? 'Café da manhã' : 'Breakfast')."</li>
                            </ul>
                            <a href='#contato' class='btn' style='width: 100%; text-align: center;'>".t('hero_botao')."</a>
                        </div>
                    </div>";
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Depoimentos -->
    <section class="depoimentos">
        <div class="container">
            <h2 class="section-title"><?php echo t('depoimentos_titulo'); ?></h2>
            <div class="depoimentos-grid">
                <?php
                // Buscar depoimentos do banco de dados com fallback
                $depoimentos = getFromDB('depoimentos', 2);
                
                // Se não houver depoimentos no banco, usar dados padrão
                if (empty($depoimentos)) {
                    $depoimentos = [
                        [
                            'texto_pt' => 'Experiência incrível! A equipe da Cleste foi excepcional e as auroras eram de tirar o fôlego.',
                            'texto_en' => 'Amazing experience! The Cleste team was exceptional and the auroras were breathtaking.',
                            'autor_pt' => 'Mariana Silva',
                            'autor_en' => 'Mariana Silva'
                        ],
                        [
                            'texto_pt' => 'Realizei um sonho de infância. Tudo foi perfeito, desde o hotel até os guias locais.',
                            'texto_en' => 'I fulfilled a childhood dream. Everything was perfect, from the hotel to the local guides.',
                            'autor_pt' => 'Carlos Mendes',
                            'autor_en' => 'Carlos Mendes'
                        ]
                    ];
                }
                
                foreach ($depoimentos as $row) {
                    $texto = $_SESSION['idioma'] == 'pt' ? $row['texto_pt'] : $row['texto_en'];
                    $autor = $_SESSION['idioma'] == 'pt' ? $row['autor_pt'] : $row['autor_en'];
                    
                    echo "
                    <div class='depoimento-card'>
                        <p>$texto</p>
                        <div class='depoimento-autor'>$autor</div>
                    </div>";
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="newsletter">
        <div class="container">
            <h2><?php echo t('newsletter_titulo'); ?></h2>
            <form class="newsletter-form" action="process/newsletter.php" method="POST">
                <input type="email" name="email" class="newsletter-input" placeholder="<?php echo t('newsletter_placeholder'); ?>" required>
                <button type="submit" class="btn"><?php echo t('newsletter_botao'); ?></button>
            </form>
        </div>
    </section>

    <!-- Contato -->
    <section id="contato">
        <div class="container">
            <h2 class="section-title"><?php echo t('contato_titulo'); ?></h2>
            <div class="contato-form">
                <?php
                if (isset($_SESSION['mensagem'])) {
                    $tipo = isset($_SESSION['mensagem_tipo']) ? $_SESSION['mensagem_tipo'] : 'sucesso';
                    echo "<div class='mensagem $tipo'>".$_SESSION['mensagem']."</div>";
                    unset($_SESSION['mensagem']);
                    unset($_SESSION['mensagem_tipo']);
                }
                ?>
                <form action="process/contact.php" method="POST">
                    <div class="form-group">
                        <label for="nome"><?php echo t('contato_nome'); ?></label>
                        <input type="text" id="nome" name="nome" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email"><?php echo t('contato_email'); ?></label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="telefone"><?php echo t('contato_telefone'); ?></label>
                        <input type="tel" id="telefone" name="telefone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="mensagem"><?php echo t('contato_mensagem'); ?></label>
                        <textarea id="mensagem" name="mensagem" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn" style="width: 100%;"><?php echo t('contato_enviar'); ?></button>
                </form>
            </div>
        </div>
    </section>

<?php include 'includes/footer.php'; ?>