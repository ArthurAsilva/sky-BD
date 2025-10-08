<?php
require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['mensagem'] = 'Por favor, insira um email válido.';
        $_SESSION['mensagem_tipo'] = 'erro';
        header('Location: ../index.php');
        exit;
    }
    
    try {
        // Verificar se email já existe
        $query = "SELECT id FROM newsletter WHERE email = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            $_SESSION['mensagem'] = 'Este email já está cadastrado em nossa newsletter.';
            $_SESSION['mensagem_tipo'] = 'erro';
        } else {
            $query = "INSERT INTO newsletter (email) VALUES (?)";
            $stmt = $db->prepare($query);
            $stmt->execute([$email]);
            
            $_SESSION['mensagem'] = 'Inscrição realizada com sucesso!';
            $_SESSION['mensagem_tipo'] = 'sucesso';
        }
        
    } catch (PDOException $e) {
        $_SESSION['mensagem'] = 'Erro ao processar inscrição. Tente novamente.';
        $_SESSION['mensagem_tipo'] = 'erro';
    }
    
    header('Location: ../index.php');
    exit;
}
?>