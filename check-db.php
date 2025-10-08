<?php
// Arquivo para verificar a conexão com o banco
echo "<h1>Verificação do Banco de Dados</h1>";

require_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();

if ($db) {
    echo "<p style='color: green;'>✅ Conexão com o banco estabelecida com sucesso!</p>";
    
    // Verificar tabelas
    $tables = ['destinos', 'pacotes', 'depoimentos', 'contatos', 'newsletter', 'administradores'];
    
    foreach ($tables as $table) {
        try {
            $result = $db->query("SELECT COUNT(*) as count FROM $table");
            $count = $result->fetch()['count'];
            echo "<p>✅ Tabela '$table': $count registros</p>";
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Tabela '$table': " . $e->getMessage() . "</p>";
        }
    }
    
    echo "<p><a href='index.php'>Ir para o site</a></p>";
    
} else {
    echo "<p style='color: red;'>❌ Não foi possível conectar ao banco de dados</p>";
    echo "<p>O site funcionará com dados estáticos.</p>";
    echo "<p><a href='index.php'>Ir para o site mesmo assim</a></p>";
}
?>