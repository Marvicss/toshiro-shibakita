<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Exemplo PHP</title>
</head>
<body>

<?php
// Exibir erros apenas em ambiente de desenvolvimento
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Charset correto
header('Content-Type: text/html; charset=UTF-8');

echo 'Versão atual do PHP: ' . phpversion() . '<br>';

// Idealmente essas variáveis deveriam vir de variáveis de ambiente (.env)
$servername = "54.234.153.24";
$username   = "root";
$password   = "Senha123";
$database   = "meubanco";

// Criar conexão orientada a objetos
$link = new mysqli($servername, $username, $password, $database);

// Verificar conexão
if ($link->connect_error) {
    die('Falha na conexão com o banco de dados: ' . $link->connect_error);
}

// Garantir charset correto na conexão
$link->set_charset('utf8mb4');

// Gerar valores
$valor_rand1 = random_int(1, 999);
$valor_rand2 = strtoupper(bin2hex(random_bytes(4)));
$host_name   = gethostname();

// Usar prepared statements (evita SQL Injection)
$stmt = $link->prepare(
    "INSERT INTO dados (AlunoID, Nome, Sobrenome, Endereco, Cidade, Host)
     VALUES (?, ?, ?, ?, ?, ?)"
);

if (!$stmt) {
    die('Erro ao preparar a query: ' . $link->error);
}

// Bind dos parâmetros
$stmt->bind_param(
    "isssss",
    $valor_rand1,
    $valor_rand2,
    $valor_rand2,
    $valor_rand2,
    $valor_rand2,
    $host_name
);

// Executar
if ($stmt->execute()) {
    echo "Registro criado com sucesso!";
} else {
    echo "Erro ao inserir registro: " . $stmt->error;
}

// Fechar recursos
$stmt->close();
$link->close();
?>

</body>
</html>
