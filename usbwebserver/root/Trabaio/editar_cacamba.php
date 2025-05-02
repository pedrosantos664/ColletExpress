<?php
session_start();
include 'conexao.php';

// Verifique se o usuário está logado como fornecedor
if (!isset($_SESSION['id_fornecedor'])) {
    die("Erro: Fornecedor não logado.");
}

$id_fornecedor = $_SESSION['id_fornecedor'];
$nome_empresa = $_SESSION["nome_empresa"];
$tipocacamba = $_POST["tipo_cacamba"];
$capacidade = $_POST["capacidade_cacamba"];
$status = $_POST["status_cacamba"];
$preco = $_POST["preco_aluguel_cacamba"];
$id_cacamba = $_POST['id_cacamba']; // ID da caçamba que será editada

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
        // Atualiza o registro da caçamba no banco de dados
        $sql_update = "UPDATE tb_cacambas SET 
                        tipo_cacamba = '$tipocacamba',
                        capacidade_cacamba = '$capacidade',
                        status_cacamba = '$status',
                        preco_aluguel_cacamba = '$preco',
                        nome_empresa = '$nome_empresa',
                        imagem_cacamba = '$caminhoImagem'
                      WHERE id_cacamba = '$id_cacamba'";

        if ($conn->query($sql_update) === TRUE) {
            $_SESSION['message'] = "Caçamba atualizada com sucesso!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Erro ao atualizar a caçamba: " . $conn->error;
            $_SESSION['message_type'] = "error";
        }
    } else {
        $_SESSION['message'] = "Erro ao mover a imagem para a pasta.";
        $_SESSION['message_type'] = "error";
    }
} else {
    // Caso não tenha uma imagem nova, atualiza os dados sem mudar a imagem
    $sql_update = "UPDATE tb_cacambas SET 
                    tipo_cacamba = '$tipocacamba',
                    capacidade_cacamba = '$capacidade',
                    status_cacamba = '$status',
                    preco_aluguel_cacamba = '$preco',
                    nome_empresa = '$nome_empresa'
                  WHERE id_cacamba = '$id_cacamba'";

    if ($conn->query($sql_update) === TRUE) {
        $_SESSION['message'] = "Caçamba atualizada com sucesso!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Erro ao atualizar a caçamba: " . $conn->error;
        $_SESSION['message_type'] = "error";
    }
}

$conn->close();
header("Location: perfilcacambeiro.php");
exit();
?>
