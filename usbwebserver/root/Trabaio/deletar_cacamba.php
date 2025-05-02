<?php
include 'conexao.php'; // Conectar ao banco de dados

// Verifica se o parâmetro 'id' foi passado na URL
if (isset($_GET['id'])) {
    $id_cacamba = $_GET['id'];

    // Prepara a consulta SQL para deletar a caçamba com o ID especificado
    $sql = "DELETE FROM tb_cacambas WHERE id_cacamba = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_cacamba);
    $stmt->execute();

    // Verifica se a caçamba foi deletada
    if ($stmt->affected_rows > 0) {
        // Sucesso, a caçamba foi deletada
        header("Location: perfilcacambeiro.php?message=Caçamba deletada com sucesso.");
    } else {
        // Erro, caçamba não foi encontrada
        header("Location: perfilcacambeiro.php?message=Erro ao deletar a caçamba.");
    }

    $stmt->close();
} else {
    // Se o parâmetro 'id' não estiver presente, redireciona com erro
    header("Location: perfilcacambeiro.php?message=Erro: ID da caçamba não encontrado.");
}

$conn->close();
?>
