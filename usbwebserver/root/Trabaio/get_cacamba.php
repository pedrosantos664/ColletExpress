<?php
// Inclua a conexão com o banco de dados
include 'conexao.php';

// Receber o ID da caçamba via GET
$id_cacamba = $_GET['id_cacamba'];

// Consulta para pegar os dados da caçamba
$sql = "SELECT * FROM tb_cacambas WHERE id_cacamba = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_cacamba);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se encontrou os dados da caçamba
if ($result->num_rows > 0) {
    $cacamba = $result->fetch_assoc();
    // Retorna os dados como JSON
    echo json_encode($cacamba);
} else {
    echo json_encode(['error' => 'Caçamba não encontrada']);
}
?>
