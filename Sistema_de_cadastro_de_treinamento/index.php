<?php
// Inclui o arquivo de conexão ao banco de dados.
include('conexao.php');

// Consulta SQL para selecionar ID e nome dos treinamentos.
$query = "SELECT ID, nome FROM treinamento";
$result = $mysqli->query($query) or die("Erro na execução da consulta: " . $mysqli->error);

// Obtém o número total de registros encontrados.
$total = $result->num_rows;

// Inicializa um array para armazenar os registros.
$linhas = [];
if ($total > 0) {
    // Loop para adicionar cada linha de resultado ao array.
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
    <title>Manter Treinamento</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container my-4">
        <hr>
        <div class="text-center">
            <h2 class="text-mid mb-4" style="color: #17562f">
                <img src="brasao_vert.png" width="50px">    
                Universidade Tuiuti do Paraná
                <img src="brasao_vert.png" width="50px">
            </h2>
        <hr>            
        </div>
        
        <h2 class="text-start mb-4">Treinamentos Cadastrados</h2>
        
        <div class="table-responsive">
            <a href="Cadastrar_treinamento.php" type="button" class="btn btn-warning">Adicionar</a>
            <?php
            // Verifica se existem treinamentos cadastrados.
            if ($total > 0) {
                // Início da tabela.
                echo '<table class="table table-striped">';
                echo '  <thead>';
                echo '      <tr>';
                echo '              <th>ID</th>';
                echo '              <th>Nome do treinamento</th>';
                echo '              <th>Ações</th>'; // Coluna para ações.
                echo '      </tr>';
                echo '  </thead>';
                echo '<tbody>';
                
                // Loop para gerar as linhas da tabela.
                foreach ($linhas as $linha) {
                    echo "<tr>";
                    echo "<td>{$linha['ID']}</td>";
                    echo "<td>{$linha['nome']}</td>";
                    echo "<td>
                            <a href='Alterar_treinamento.php?id={$linha['ID']}' class='btn btn-primary btn-sm'>Alterar</a>
                            <a href='Excluir_treinamento.php?id={$linha['ID']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir?\");'>Excluir</a>
                          </td>";
                    echo "</tr>";
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                // Mensagem caso não haja treinamentos cadastrados.
                echo "<p class='text-center'>Nenhum treinamento encontrado.</p>";
            }
            ?>
        </div>
        <hr>
    </div>

    <!-- Inclusão do JavaScript do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Libera o resultado da consulta.
$result->free();
?>
