<?php
require_once '../config/config.php';

// Limpar sessão
$_SESSION = array();

// Destruir sessão
session_destroy();

// Redirecionar para login
header('Location: login.php');
exit;
?>