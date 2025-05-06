<?php
session_start();

// Verificar se o cliente está logado
if (!isset($_SESSION['id_cliente'])) {
    die("Erro: Usuário não está logado.");
}

// Conectar ao banco de dados
include 'conexao.php';

// Verificar a conexão
if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}

// Definir o timezone (ajuste conforme sua região)
date_default_timezone_set('America/Sao_Paulo');

// Identificar o cliente logado
$id_cliente = $_SESSION['id_cliente'];

// Pegar os dados do formulário
$endereco = $_POST['address'];
$numero = $_POST['number'];
$opcao_pagamento = $_POST['payment_method'];
$tempo_aluguel = $_POST['days'];
$data_aluguel = date('Y-m-d H:i:s'); // Data atual

// Se a opção de pagamento for "Cartão de Crédito", pegar os dados adicionais
$numero_cartao = isset($_POST['card_number']) ? $_POST['card_number'] : null;
$nome_cartao = isset($_POST['card_holder']) ? $_POST['card_holder'] : null;
$validade_cartao = isset($_POST['expiry_date']) ? $_POST['expiry_date'] : null;
$cvv_cartao = isset($_POST['cvv']) ? $_POST['cvv'] : null;

// Consultar os itens do carrinho
$query_carrinho = "SELECT c.id_cacamba, c.quantidade, ca.preco_aluguel_cacamba
                   FROM tb_carrinho c
                   JOIN tb_cacambas ca ON c.id_cacamba = ca.id_cacamba
                   WHERE c.id_cliente = ?";
$stmt = mysqli_prepare($conn, $query_carrinho);
if (!$stmt) {
    die("Erro na preparação da consulta de carrinho: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, 'i', $id_cliente);
mysqli_stmt_execute($stmt);
$resultado_carrinho = mysqli_stmt_get_result($stmt);

// Verificar se o carrinho contém itens
if (mysqli_num_rows($resultado_carrinho) == 0) {
    die("Erro: Nenhum item encontrado no carrinho.");
}

// Verificar se o cliente existe na tabela tb_cliente
$query_cliente = "SELECT id_cliente FROM tb_cliente WHERE id_cliente = ?";
$stmt_cliente = mysqli_prepare($conn, $query_cliente);
if (!$stmt_cliente) {
    die("Erro na preparação da consulta do cliente: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt_cliente, 'i', $id_cliente);
mysqli_stmt_execute($stmt_cliente);
$resultado_cliente = mysqli_stmt_get_result($stmt_cliente);

if (mysqli_num_rows($resultado_cliente) == 0) {
    die("Erro: O cliente não existe na tabela de clientes.");
}

// Inserir os itens do carrinho na tabela tb_cacamba_alugada
while ($row = mysqli_fetch_assoc($resultado_carrinho)) {
    $id_cacamba = $row['id_cacamba'];
    $quantidade = $row['quantidade'];
    $preco_aluguel = $row['preco_aluguel_cacamba'];

    // Inserir o aluguel na tabela tb_cacamba_alugada
    $query_aluguel = "INSERT INTO tb_cacamba_alugada (id_cacamba, id_cliente, endereco, numero, opcao_pagamento, numero_cartao, nome_cartao, validade_cartao, cvv_cartao, tempo_aluguel, data_aluguel) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_aluguel = mysqli_prepare($conn, $query_aluguel);
    if (!$stmt_aluguel) {
        die("Erro na preparação da consulta de aluguel: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt_aluguel, 'iisssssssis', $id_cacamba, $id_cliente, $endereco, $numero, $opcao_pagamento, $numero_cartao, $nome_cartao, $validade_cartao, $cvv_cartao, $tempo_aluguel, $data_aluguel);

    $execute_result = mysqli_stmt_execute($stmt_aluguel);

    if (!$execute_result) {
        die("Erro ao executar a consulta de aluguel: " . mysqli_error($conn));
    }

    // Atualizar o status da caçamba para 1 (alugada)
    $query_atualizar_status = "UPDATE tb_cacambas SET status_cacamba = 1 WHERE id_cacamba = ?";
    $stmt_atualizar_status = mysqli_prepare($conn, $query_atualizar_status);
    if (!$stmt_atualizar_status) {
        die("Erro na preparação da consulta para atualizar status da caçamba: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt_atualizar_status, 'i', $id_cacamba);
    $execute_status = mysqli_stmt_execute($stmt_atualizar_status);
    if (!$execute_status) {
        die("Erro ao executar a consulta para atualizar o status da caçamba: " . mysqli_error($conn));
    }
}

// Remover os itens do carrinho
$query_remover_carrinho = "DELETE FROM tb_carrinho WHERE id_cliente = ?";
$stmt_remover_carrinho = mysqli_prepare($conn, $query_remover_carrinho);
if (!$stmt_remover_carrinho) {
    die("Erro na preparação da consulta para remover itens do carrinho: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt_remover_carrinho, 'i', $id_cliente);
mysqli_stmt_execute($stmt_remover_carrinho);

// Redirecionar para a página de confirmação ou para a página inicial
header("Location: confirmacao_pedido.php");
exit();
?>
