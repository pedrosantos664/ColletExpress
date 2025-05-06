<?php
session_start();
include 'conexao.php';

// Verifique se o usuário está logado como fornecedor
if (!isset($_SESSION['id_fornecedor'])) {
    die("Erro: Fornecedor não logado.");
}

$id_fornecedor = $_SESSION['id_fornecedor'];
$nome_empresa = $_SESSION["nome_empresa"];
$tipocacamba = $_POST["tipocacamba"];
$capacidade = $_POST["capacidade"];
$status = $_POST["status"];
$preco = $_POST["preco"];

// Verifique se a imagem foi enviada e se não há erros no upload
if (isset($_FILES['imagem_cacamba']) && $_FILES['imagem_cacamba']['error'] === UPLOAD_ERR_OK) {
    $imagem = $_FILES['imagem_cacamba'];

    // Define o diretório onde a imagem será salva
    $diretorio = 'imagens/';
    if (!is_dir($diretorio)) {
        mkdir($diretorio, 0755, true); // Cria o diretório se não existir
    }
    
    // Gera um nome único para a imagem
    $nomeImagem = uniqid() . '-' . basename($imagem['name']);
    $caminhoImagem = $diretorio . $nomeImagem;

    // Move a imagem para o diretório desejado
    if (move_uploaded_file($imagem['tmp_name'], $caminhoImagem)) {
        // Salva o registro da caçamba e o caminho da imagem no banco de dados
        $sql_insert = "INSERT INTO tb_cacambas (id_fornecedor, nome_empresa, tipo_cacamba, capacidade_cacamba, status_cacamba, preco_aluguel_cacamba, imagem_cacamba) 
                       VALUES ('$id_fornecedor', '$nome_empresa', '$tipocacamba', '$capacidade', '$status', '$preco', '$caminhoImagem')";
        
        if ($conn->query($sql_insert) === TRUE) {
            $_SESSION['message'] = "Caçamba cadastrada com sucesso!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Erro ao cadastrar a caçamba: " . $conn->error;
            $_SESSION['message_type'] = "error";
        }
    } else {
        $_SESSION['message'] = "Erro ao mover a imagem para a pasta.";
        $_SESSION['message_type'] = "error";
    }
} else {
    $_SESSION['message'] = "Nenhuma imagem foi enviada ou houve um erro no upload.";
    $_SESSION['message_type'] = "error";
}

$conn->close();
header("Location: ccacamba.php");
exit();
?>
