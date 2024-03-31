<?php
require_once '../config/connectionDb.php';

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Dados do formulário
    $nome = htmlspecialchars($_POST['nome']); // Converter caracteres especiais em entidades HTML
    $valor_taxa = $_POST['valor_taxa'];

    // Inserir na base de dados
    try {
        $sql = "INSERT INTO categorias (nome, valor_taxa) VALUES (:nome, :valor_taxa)";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':valor_taxa', $valor_taxa);
        $stmt->execute();
        echo '<script type="text/javascript">alert("Categoria cadastrada com sucesso!");</script>';
    } catch (PDOException $e) {
        echo "Erro ao cadastrar categoria: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Categorias</title>
    <link rel="stylesheet" href="../css/stylepages.css">
    <link rel="shortcut icon" href="../img/image-removebg-preview (2).png" type="image/x-icon">
</head>
<body>
    
    <h1>Cadastro de Categorias</h1>

    <section class="formulario">
        <div class="card-from">
            <form action="cadastro_categorias.php" method="post">
                <label for="nome">Nome da Categoria:</label>
                <input type="text" id="nome" name="nome" required><br>
                <label for="valor_taxa">Valor da Taxa:</label>
                <input type="number" step="0.01" id="valor_taxa" name="valor_taxa" required><br>
                <input type="submit" value="Cadastrar">
                <a href="../index.php" class="btn-home">Home</a>
            </form>
        </div>
    </section>

    

</body>
</html>
