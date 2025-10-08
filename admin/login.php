<?php
require_once '../config/config.php';

// Redirecionar se já estiver logado
if (isset($_SESSION['admin_logado']) && $_SESSION['admin_logado'] === true) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
    $senha = $_POST['senha'];
    
    try {
        $query = "SELECT * FROM administradores WHERE usuario = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$usuario]);
        
        if ($stmt->rowCount() > 0) {
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (password_verify($senha, $admin['senha'])) {
                $_SESSION['admin_logado'] = true;
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_nome'] = $admin['nome'];
                
                header('Location: dashboard.php');
                exit;
            }
        }
        
        $erro = 'Usuário ou senha inválidos.';
        
    } catch (PDOException $e) {
        $erro = 'Erro ao processar login. Tente novamente.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cleste Aviation Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Cleste Aviation - Admin</h2>
            
            <?php if (isset($erro)): ?>
                <div class="mensagem erro"><?php echo $erro; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="usuario">Usuário</label>
                    <input type="text" id="usuario" name="usuario" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" class="form-control" required>
                </div>
                <button type="submit" class="btn" style="width: 100%;">Entrar</button>
            </form>
            
            <p style="text-align: center; margin-top: 1rem; font-size: 0.9rem;">
                Usuário: admin | Senha: password
            </p>
        </div>
    </div>
</body>
</html>