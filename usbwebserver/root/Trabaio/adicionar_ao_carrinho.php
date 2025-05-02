<?php
session_start();
include 'conexao.php';

// Verifique se os dados necessários estão presentes
if (!isset($_POST['id_cacamba']) || !isset($_POST['quantidade'])) {
    die("Dados incompletos para adicionar ao carrinho.");
}

// Converta os valores enviados
$id_cacamba = (int)$_POST['id_cacamba'];
$quantidade = (int)$_POST['quantidade'];

// Valide os valores
if ($id_cacamba <= 0 || $quantidade <= 0) {
    die("Erro: Valores inválidos.");
}

// Verifique se o cliente está logado
if (!isset($_SESSION['id_cliente'])) {
    die("Erro: Cliente não está logado.");
}

$id_cliente = (int)$_SESSION['id_cliente'];

// Validar se a caçamba existe no banco
$query_validar = "SELECT * FROM tb_cacambas WHERE id_cacamba = $id_cacamba";
$resultado_validar = mysqli_query($conn, $query_validar);

if (!$resultado_validar || mysqli_num_rows($resultado_validar) === 0) {
    die("Erro: Caçamba não encontrada no banco de dados.");
}

// Verifique se a caçamba já está no carrinho
$query_verifica = "SELECT * FROM tb_carrinho WHERE id_cliente = $id_cliente AND id_cacamba = $id_cacamba";
$resultado_verifica = mysqli_query($conn, $query_verifica);

if (!$resultado_verifica) {
    die("Erro ao verificar o carrinho: " . mysqli_error($conn));
}

// Atualize ou insira no carrinho
if (mysqli_num_rows($resultado_verifica) > 0) {
    // Atualizar a quantidade se já estiver no carrinho
    $query_update = "UPDATE tb_carrinho 
                     SET quantidade = quantidade + $quantidade 
                     WHERE id_cliente = $id_cliente AND id_cacamba = $id_cacamba";
    if (!mysqli_query($conn, $query_update)) {
        die("Erro ao atualizar o carrinho: " . mysqli_error($conn));
    }
} else {
    // Inserir um novo item no carrinho
    $query_inserir = "INSERT INTO tb_carrinho (id_cliente, id_cacamba, quantidade) 
                      VALUES ($id_cliente, $id_cacamba, $quantidade)";
    if (!mysqli_query($conn, $query_inserir)) {
        die("Erro ao adicionar ao carrinho: " . mysqli_error($conn));
    }
}

// Redirecionar para o carrinho após a operação
header("Location: carrinho.php");
exit();
