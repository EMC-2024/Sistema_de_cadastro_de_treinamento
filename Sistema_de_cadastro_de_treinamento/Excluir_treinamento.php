<?php
// Inclui o arquivo de conexão ao banco de dados.
include("conexao.php");

// Verifica se o ID foi passado via GET.
if (isset($_GET['id'])) {
    // Converte o ID para um número inteiro.
    $id = intval($_GET['id']);

    // Prepara a instrução SQL para deletar o treinamento com o ID fornecido.
    $stmt = $mysqli->prepare("DELETE FROM treinamento WHERE ID = ?");
    // Liga o parâmetro ID à instrução SQL.
    $stmt->bind_param("i", $id);

    // Executa a instrução SQL.
    if ($stmt->execute()) {
        // Redireciona para a página principal se a exclusão for bem-sucedida.
        header("Location: index.php");
        exit;
    } else {
        // Exibe uma mensagem de erro se a exclusão falhar.
        echo "<div class='alert alert-danger' role='alert'>Erro ao excluir treinamento: " . $stmt->error . "</div>";
    }

    // Fecha a declaração preparada.
    $stmt->close();
} else {
    // Exibe uma mensagem de erro se o ID não for fornecido.
    echo "<div class='alert alert-danger' role='alert'>ID não fornecido.</div>";
}

// Fecha a conexão com o banco de dados.
$mysqli->close();
?>
