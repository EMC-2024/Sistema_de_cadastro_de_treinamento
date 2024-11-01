<?php
// Inclui o arquivo de conexão com o banco de dados.
include('conexao.php');

// Verifica se a requisição é do tipo POST.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se o campo 'treinamento' está vazio.
    if (empty($_POST['treinamento'])) {
        echo "<div class='alert alert-warning'>Preencha seu departamento</div>"; // Alerta para campo vazio
    } else {
        // Escapa caracteres especiais para evitar SQL Injection.
        $nome = $mysqli->real_escape_string($_POST['treinamento']);

        // Consulta para verificar se o treinamento já está cadastrado.
        $sql_code = "SELECT * FROM treinamento WHERE nome = '$nome'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

        // Verifica se o treinamento já existe.
        if ($sql_query->num_rows > 0) {
            echo "<div class='alert alert-danger'>Treinamento já cadastrado.</div>"; // Alerta caso já exista
        } else {
            // Instrução para inserir um novo treinamento.
            $insert_code = "INSERT INTO treinamento (nome) VALUES ('$nome')";
            if ($mysqli->query($insert_code)) {
                echo "<div class='alert alert-success'>Treinamento cadastrado com sucesso!</div>"; // Sucesso
            } else {
                echo "<div class='alert alert-danger'>Erro ao cadastrar treinamento: " . $mysqli->error . "</div>"; // Erro
            }
        }
    }
}

// Consulta para listar todos os treinamentos cadastrados.
$query = "SELECT ID, nome FROM treinamento";
$result = $mysqli->query($query) or die("Erro na execução da consulta: " . $mysqli->error);

// Verifica o número total de registros encontrados.
$total = $result->num_rows;

// Array para armazenar os registros dos treinamentos.
$linhas = [];
if ($total > 0) {
    // Preenche o array com os dados dos treinamentos.
    while ($linha = $result->fetch_assoc()) {
        $linhas[] = $linha;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Treinamento</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
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
        
        <!-- Formulário para cadastro de novo treinamento -->
        <form method="POST">
            <div class="mb-3">
                <label for="treinamento-input" class="form-label">Nome do treinamento:</label>
                <input type="text" name="treinamento" id="treinamento-input" class="form-control" placeholder="Nome" required>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit"  class="btn btn-success">Cadastrar</button>
                <a href="index.php" class="btn btn-dark">Voltar</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Libera o resultado da consulta.
$result->free();
?>
