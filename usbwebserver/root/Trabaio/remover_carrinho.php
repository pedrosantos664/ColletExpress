<?php
session_start();
include 'conexao.php';

// Verifica se o carrinho está em sessão e se o id_cacamba foi enviado
if (isset($_SESSION['id_cliente']) && isset($_POST['id_cacamba'])) {
    $id_cliente = $_SESSION['id_cliente'];  // Obtém o id_cliente da sessão
    $id_cacamba = $_POST['id_cacamba'];    // Obtém o id_cacamba enviado no formulário

    // Consulta SQL para verificar se o item existe no carrinho
    $query_verifica = "SELECT * FROM tb_carrinho WHERE id_cliente = ? AND id_cacamba = ?";
    $stmt = mysqli_prepare($conn, $query_verifica);
    mysqli_stmt_bind_param($stmt, 'ii', $id_cliente, $id_cacamba);
    mysqli_stmt_execute($stmt);
    $resultado_verifica = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultado_verifica) > 0) {
        // Se o item existe no carrinho, realiza a remoção
        $query_remover = "DELETE FROM tb_carrinho WHERE id_cliente = ? AND id_cacamba = ?";
        $stmt = mysqli_prepare($conn, $query_remover);
        mysqli_stmt_bind_param($stmt, 'ii', $id_cliente, $id_cacamba);

        if (mysqli_stmt_execute($stmt)) {
            // Redireciona para o carrinho com sucesso
            header("Location: carrinho.php?status=success");
            exit();
        } else {
            // Caso ocorra erro na remoção
            header("Location: carrinho.php?status=error_removing");
            exit();
        }
    } else {
        // Caso o item não seja encontrado no carrinho
        header("Location: carrinho.php?status=error_item_not_found");
        exit();
    }

    mysqli_stmt_close($stmt);
} else {
    // Caso os dados necessários não sejam passados
    header("Location: carrinho.php?status=error_invalid_request");
    exit();
}
if (isset($_GET['status'])): ?>
    <?php if ($_GET['status'] == 'success'): ?>
        <p style="color: green;">Item removido com sucesso do carrinho!</p>
    <?php elseif ($_GET['status'] == 'error_removing'): ?>
        <p style="color: red;">Erro: Não foi possível remover o item.</p>
    <?php elseif ($_GET['status'] == 'error_item_not_found'): ?>
        <p style="color: red;">Erro: O item não foi encontrado no carrinho.</p>
    <?php elseif ($_GET['status'] == 'error_invalid_request'): ?>
        <p style="color: red;">Erro: Solicitação inválida.</p>
    <?php endif; ?>
<?php endif; ?>
