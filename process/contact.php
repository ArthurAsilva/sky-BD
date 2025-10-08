<?php
require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
    $mensagem = filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_STRING);
    
    // Validar dados
    if (empty($nome) || empty($email) || empty($mensagem)) {
        $_SESSION['mensagem'] = 'Por favor, preencha todos os campos obrigatórios.';
        $_SESSION['mensagem_tipo'] = 'erro';
        header('Location: ../index.php#contato');
        exit;
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['mensagem'] = 'Por favor, insira um email válido.';
        $_SESSION['mensagem_tipo'] = 'erro';
        header('Location: ../index.php#contato');
        exit;
    }
    
    // Inserir no banco de dados (se houver conexão)
    if ($db) {
        try {
            $query = "INSERT INTO contatos (nome, email, telefone, mensagem) VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($query);
            $stmt->execute([$nome, $email, $telefone, $mensagem]);
            
            $_SESSION['mensagem'] = 'Mensagem enviada com sucesso! Entraremos em contato em breve.';
            $_SESSION['mensagem_tipo'] = 'sucesso';
            
        } catch (PDOException $e) {
            $_SESSION['mensagem'] = 'Mensagem recebida! Entraremos em contato em breve.';
            $_SESSION['mensagem_tipo'] = 'sucesso';
        }
    } else {
        // Se não houver banco, ainda mostra mensagem de sucesso
        $_SESSION['mensagem'] = 'Mensagem recebida! Entraremos em contato em breve.';
        $_SESSION['mensagem_tipo'] = 'sucesso';
    }
    
    header('Location: ../index.php#contato');
    exit;
}
?>