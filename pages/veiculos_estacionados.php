<?php
require_once '../config/connectionDb.php';

try {
    // Consulta para obter os veículos com suas entradas, saídas, tempo de permanência e valor cobrado
    $sql = "SELECT v.placa, v.data_entrada, v.data_saida, TIMEDIFF(v.data_saida, v.data_entrada) AS tempo_permanencia, v.valor_cobranca, c.nome AS categoria_nome 
            FROM veiculos v 
            JOIN categorias c ON v.categoria_id = c.id";
    $stmt = $conectar->prepare($sql);
    $stmt->execute();
    $veiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao recuperar os veículos: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="../css/stylepages.css">
    <link rel="shortcut icon" href="../img/image-removebg-preview (2).png" type="image/x-icon">

    <title>Veículos Estacionados</title>
</head>
<body>
    <h1>Veículos Estacionados</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Placa</th>
                <th>Data de Entrada</th>
                <th>Data de Saída</th>
                <th>Tempo de Permanência</th>
                <th>Valor Cobrado</th>
                <th>Categoria</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($veiculos as $veiculo): ?>
                <tr>
                    <td><?= $veiculo['placa'] ?></td>
                    <td><?= $veiculo['data_entrada'] ?></td>
                    <td><?= $veiculo['data_saida'] ? $veiculo['data_saida'] : '-' ?></td>
                    <td><?= $veiculo['tempo_permanencia'] ? $veiculo['tempo_permanencia'] : '-' ?></td>
                    <td><?= $veiculo['valor_cobranca'] ? 'R$ ' . number_format($veiculo['valor_cobranca'], 2) : '-' ?></td>
                    <td><?= $veiculo['categoria_nome'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="../index.php" class="btn-home">Voltar para a Home</a>
</body>
</html>
