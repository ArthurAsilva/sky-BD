<?php
require_once '../config/config.php';

// Verificar se está logado
if (!isset($_SESSION['admin_logado']) || $_SESSION['admin_logado'] !== true) {
    header('Location: login.php');
    exit;
}

// Estatísticas
try {
    $query_contatos = "SELECT COUNT(*) as total FROM contatos";
    $stmt = $db->prepare($query_contatos);
    $stmt->execute();
    $total_contatos = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    $query_newsletter = "SELECT COUNT(*) as total FROM newsletter WHERE ativo = TRUE";
    $stmt = $db->prepare($query_newsletter);
    $stmt->execute();
    $total_newsletter = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    $query_destinos = "SELECT COUNT(*) as total FROM destinos WHERE ativo = TRUE";
    $stmt = $db->prepare($query_destinos);
    $stmt->execute();
    $total_destinos = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    $query_pacotes = "SELECT COUNT(*) as total FROM pacotes WHERE ativo = TRUE";
    $stmt = $db->prepare($query_pacotes);
    $stmt->execute();
    $total_pacotes = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
} catch (PDOException $e) {
    // Em caso de erro, definir valores padrão
    $total_contatos = $total_newsletter = $total_destinos = $total_pacotes = 0;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Cleste Aviation Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="admin-container">
        <header class="admin-header">
            <div class="container">
                <div class="header-content">
                    <div class="logo">
                        <i>✈</i> Cleste Aviation - Admin
                    </div>
                    <nav class="admin-nav">
                        <ul>
                            <li><a href="dashboard.php" class="ativo">Dashboard</a></li>
                            <li><a href="destinos.php">Destinos</a></li>
                            <li><a href="pacotes.php">Pacotes</a></li>
                            <li><a href="depoimentos.php">Depoimentos</a></li>
                            <li><a href="../index.php" target="_blank">Ver Site</a></li>
                            <li><a href="logout.php">Sair</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>

        <main class="admin-main">
            <div class="container">
                <h1>Dashboard</h1>
                <p>Bem-vindo, <?php echo $_SESSION['admin_nome']; ?>!</p>
                
                <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; margin: 2rem 0;">
                    <div class="stat-card" style="background: white; padding: 2rem; border-radius: 10px; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <h3 style="color: var(--azul-profundo); font-size: 2.5rem; margin: 0;"><?php echo $total_contatos; ?></h3>
                        <p style="color: var(--cinza-escuro); margin: 0.5rem 0 0 0;">Contatos</p>
                    </div>
                    <div class="stat-card" style="background: white; padding: 2rem; border-radius: 10px; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <h3 style="color: var(--azul-profundo); font-size: 2.5rem; margin: 0;"><?php echo $total_newsletter; ?></h3>
                        <p style="color: var(--cinza-escuro); margin: 0.5rem 0 0 0;">Newsletter</p>
                    </div>
                    <div class="stat-card" style="background: white; padding: 2rem; border-radius: 10px; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <h3 style="color: var(--azul-profundo); font-size: 2.5rem; margin: 0;"><?php echo $total_destinos; ?></h3>
                        <p style="color: var(--cinza-escuro); margin: 0.5rem 0 0 0;">Destinos</p>
                    </div>
                    <div class="stat-card" style="background: white; padding: 2rem; border-radius: 10px; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <h3 style="color: var(--azul-profundo); font-size: 2.5rem; margin: 0;"><?php echo $total_pacotes; ?></h3>
                        <p style="color: var(--cinza-escuro); margin: 0.5rem 0 0 0;">Pacotes</p>
                    </div>
                </div>
                
                <div class="tabela">
                    <h2 style="padding: 1rem; margin: 0; background: var(--azul-profundo); color: white;">Últimos Contatos</h2>
                    <?php
                    try {
                        $query = "SELECT * FROM contatos ORDER BY created_at DESC LIMIT 5";
                        $stmt = $db->prepare($query);
                        $stmt->execute();
                        
                        if ($stmt->rowCount() > 0) {
                            echo '<table>';
                            echo '<thead><tr><th>Nome</th><th>Email</th><th>Data</th><th>Lido</th></tr></thead>';
                            echo '<tbody>';
                            
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $lido = $row['lido'] ? 'Sim' : 'Não';
                                $data = date('d/m/Y H:i', strtotime($row['created_at']));
                                echo "<tr>
                                    <td>{$row['nome']}</td>
                                    <td>{$row['email']}</td>
                                    <td>$data</td>
                                    <td>$lido</td>
                                </tr>";
                            }
                            
                            echo '</tbody></table>';
                        } else {
                            echo '<p style="padding: 2rem; text-align: center;">Nenhum contato encontrado.</p>';
                        }
                    } catch (PDOException $e) {
                        echo '<p style="padding: 2rem; text-align: center;">Erro ao carregar contatos.</p>';
                    }
                    ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>