<?php

// Credenciais para a conexão com o banco de dados.
$usuario = 'root'; // Nome de usuário do banco de dados.
$senha = ''; // Senha do banco de dados.
$database = 'treinamento'; // Nome do banco de dados.
$host = 'localhost'; // Endereço do servidor (geralmente 'localhost').

// Cria uma nova conexão com o banco de dados MySQL.
$mysqli = new mysqli($host, $usuario, $senha, $database);

// Verifica se houve um erro na conexão.
if($mysqli->error){
    // Exibe uma mensagem de erro e encerra o script.
    die("Falha ao conectar ao banco de dados: " . $mysqli->error);
}

?>
