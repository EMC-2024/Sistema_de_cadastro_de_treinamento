<?php
//Inclui o arquivo de conexão ao banco de dados.
include("conexao.php");

//Verifica se o ID foi passado via GET.
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);  //Converte o ID para inteiro.
    
    //Prepara a consulta para selecionar o treinamento correspondente ao ID.
    $stmt = $mysqli->prepare("SELECT ID, nome FROM treinamento WHERE ID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    //Verifica se o treinamento foi encontrado.
    if ($result->num_rows > 0) {
        $departamento = $result->fetch_assoc();  //Armazena os dados do treinamento.
    } else {
        echo "<p>Treinamento não encontrado.</p>";
        exit;  //Encerra a execução se não encontrar o treinamento.
    }
    
    $stmt->close();  //Fecha a consulta.
} else {
    echo "<p>ID não fornecido.</p>";
    exit;  //Encerra a execução se o ID não for passado.
}

//Verifica se a requisição é do tipo POST.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $novo_nome = $mysqli->real_escape_string($_POST['nome']);

    //Prepara a consulta para atualizar o nome do treinamento.
    $stmt = $mysqli->prepare("UPDATE treinamento SET nome = ? WHERE ID = ?");
    $stmt->bind_param("si", $novo_nome, $id);
    
    //Executa a atualização.
    if ($stmt->execute()) {
        header("refresh:2; url=index.php");  //Redireciona após 2 segundos.
        exit;  //Encerra a execução.
    } else {
        echo "<div class='alert alert-danger' role='alert'>Erro ao atualizar treinamento: " . $stmt->error . "</div>";
    }
    
    $stmt->close();  //Fecha a consulta.
}

$mysqli->close();  //Fecha a consulta com o banco de dados.
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <hr>
        <div class="text-center mb-4">
            <h2 style="color: #17562f;">
                <img src="brasao_vert.png" width="50px">    
                Universidade Tuiuti do Paraná
                <img src="brasao_vert.png" width="50px">
            </h2>
            <hr>
        </div>

        <div class="row justify-content-center">
                <form method="POST">
                    <div class="mb-3">
                        <label for="treinamento-input" class="form-label">Nome do Treinamento:</label>
                        <input type="text" name="nome" id="treinamento-input" class="form-control" value="<?php echo htmlspecialchars($departamento['nome']); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href='index.php' class="btn btn-secondary">Cancelar</a>
                </form>
        </div>
        <hr>
    </div>
</body>
</html>
