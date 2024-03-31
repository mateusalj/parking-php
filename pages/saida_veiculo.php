<?php
require_once '../config/connectionDb.php';

function calcularValorCobranca($conectar, $categoria_id, $tempoPermanencia) {
    // Buscar a taxa da categoria no banco de dados
    $sql = "SELECT valor_taxa FROM categorias WHERE id = :categoria_id";
    $stmt = $conectar->prepare($sql);
    $stmt->bindParam(':categoria_id', $categoria_id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar se a categoria foi encontrada
    if ($row) {
        // Calcular o valor de cobrança com base na taxa da categoria e no tempo de permanência
        $valorTaxaFixa = $row['valor_taxa'];
        $valorCobranca = $valorTaxaFixa;

        // A cada hora, adicionar um valor fixo extra da categoria
        if ($tempoPermanencia > 1) {
            $valorTaxaExtra = $valorTaxaFixa * ($tempoPermanencia - 1); // Subtrai 1 para remover a primeira hora
            $valorCobranca += $valorTaxaExtra;
        }

        return $valorCobranca;
    } else {
        // Se a categoria não foi encontrada, retornar null
        return null;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $placa = $_POST['placa'];
    $data_saida = date('Y-m-d H:i:s');

    $sql = "SELECT id, data_entrada, categoria_id FROM veiculos WHERE placa = :placa AND data_saida IS NULL";
    $stmt = $conectar->prepare($sql);
    $stmt->bindParam(':placa', $placa);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo '<script type="text/javascript">alert("Não há entrada registrada para este veículo!");</script>';
    } else {
        $data_entrada = $row['data_entrada'];
        $tempoPermanencia = (strtotime($data_saida) - strtotime($data_entrada)) / 3600; // Em horas

        $categoria_id = $row['categoria_id'];
        $valorCobranca = calcularValorCobranca($conectar, $categoria_id, $tempoPermanencia);

        if ($valorCobranca === null) {
            echo '<script type="text/javascript">alert("Categoria não encontrada!");</script>';
        } else {
            try {
                $sql = "UPDATE veiculos SET data_saida = :data_saida, valor_cobranca = :valor_cobranca WHERE id = :id";
                $stmt = $conectar->prepare($sql);
                $stmt->bindParam(':data_saida', $data_saida);
                $stmt->bindParam(':valor_cobranca', $valorCobranca);
                $stmt->bindParam(':id', $row['id']);
                $stmt->execute();

                echo '<script type="text/javascript">alert("Saída registrada com sucesso! Valor de cobrança: R$ ' . number_format($valorCobranca, 2) . '");</script>';
            } catch (PDOException $e) {
                echo "Erro ao registrar saída: " . $e->getMessage();
            }
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

    <title>Saída de Veículos</title>
</head>
<body>
    
    <h1>Saída de Veículos</h1>

    <section class="formulario">
        <div class="card-from">
            <form action="" method="post">
                <label for="placa">Placa:</label>
                <input type="text" id="placa" name="placa" required=""><br>
                <input class="btnsaida" type="submit" value="Registrar Saída">
                <a href="../index.php" class="btnhomesaida">Home</a>
            </form>        
        </div>
    </section>
</body>
</html>
