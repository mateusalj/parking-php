<?php
require_once '../config/connectionDb.php';

// Função para verificar se o veículo já está no estacionamento
// Função para verificar se o veículo já está no estacionamento
function verificarEntradaExistente($conectar, $placa)
{
    $sql = "SELECT COUNT(*) FROM veiculos WHERE placa = :placa";
    $stmt = $conectar->prepare($sql);
    $stmt->bindParam(':placa', $placa);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    return $count > 0;
}


// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Dados do formulário
    $placa = $_POST['placa'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $ano = $_POST['ano'];
    $cor = $_POST['cor'];
    $categoria_id = $_POST['categoria'];

    // Verificar se o veículo já está no estacionamento
    if (verificarEntradaExistente($conectar, $placa)) {
        echo '<script type="text/javascript">alert("Veículo já está no estacionamento!");</script>';
    } else {
        // Inserir na base de dados
        try {
            $data_entrada = date('Y-m-d H:i:s'); // Obtém a data e hora atual
            $sql = "INSERT INTO veiculos (placa, marca, modelo, ano, cor, categoria_id, data_entrada) VALUES (:placa, :marca, :modelo, :ano, :cor, :categoria_id, :data_entrada)";
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':placa', $placa);
            $stmt->bindParam(':marca', $marca);
            $stmt->bindParam(':modelo', $modelo);
            $stmt->bindParam(':ano', $ano);
            $stmt->bindParam(':cor', $cor);
            $stmt->bindParam(':categoria_id', $categoria_id);
            $stmt->bindParam(':data_entrada', $data_entrada);
            $stmt->execute();
            echo '<script type="text/javascript">alert("Veículo cadastrado com sucesso!");</script>';
        } catch (PDOException $e) {
            echo "Erro ao cadastrar veículo: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="../css/stylepages.css">
    <link rel="shortcut icon" href="../img/image-removebg-preview (2).png" type="image/x-icon">

    <title>Cadastro de Veículos</title>

</head>
<body>

    <h1>Cadastro de Veículos</h1>


    <section class="formulario">
        <div class="card-from">
            <form action="cadastro_veiculo.php" method="post">
                <label for="placa">Placa:</label>
                <input type="text" id="placa" name="placa" required=""><br>
                <label for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" required=""><br>
                <label for="modelo">Modelo:</label>
                <input type="text" id="modelo" name="modelo" required=""><br>
                <label for="ano">Ano:</label>
                <input type="number" id="ano" name="ano" required=""><br>
                <label for="cor">Cor:</label>
                <input type="text" id="cor" name="cor" required=""><br>
                <label for="categoria">Categoria:</label><br>
                <select id="categoria" name="categoria" required="">
                    <?php
                    $sql = "SELECT id, nome FROM categorias";
                    $stmt = $conectar->prepare($sql);
                    $stmt->execute();
                    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($categorias as $categoria) {
                        echo '<option value="' . $categoria['id'] . '">' . $categoria['nome'] . '</option>';
                    }
                    ?>
                </select><br>
                <input type="submit" value="Cadastrar">
                <a href="../index.php" class="btn-home">Home</a>
            </form>
        </div>
    </section>    


</body>
</html>
