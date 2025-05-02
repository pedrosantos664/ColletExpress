<?php 
include 'conexao.php'; // Certifique-se de que o caminho está correto

// Verifique se a conexão foi estabelecida
if ($conn->connect_error) {
    die("Erro de conexão com o banco de dados: " . $conn->connect_error);
}

// Captura os dados do formulário
$nomeEmpresa = $_POST["nomeEmpresa"];
$email = $_POST["email"];
$cnpj = $_POST["cnpj"];
$cep = $_POST["cep"];
$numeroendereco = $_POST["numcasa"];
$telefone = $_POST["telefone"];
$senha = $_POST["senha"];

// // Protegendo contra SQL Injection
// $nome = $conn->real_escape_string($nome);
// $cpf = $conn->real_escape_string($cpf);
// $cnpj = $conn->real_escape_string($cnpj);
// $numcasa = $conn->real_escape_string($numcasa);
// $telefone = $conn->real_escape_string($telefone);
// $email = $conn->real_escape_string($email);
// $senha = $conn->real_escape_string($senha);

// Criptografar a senha (usando MD5 apenas para fins de exemplo; use `password_hash()` para maior segurança em produção)
$senha_cripto = md5($senha); // Troque por password_hash() em produção

// Verifica se o e-mail já existe
$sql = "SELECT * FROM tb_fornecedor WHERE email_fornecedor='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<center>";
    echo "<hr>";
    echo "CONTA EXISTENTE!!!";
    echo "<hr>";
    echo "<br>";
} else {
    // Cadastra o novo usuário
    $sql = "INSERT INTO tb_fornecedor (nome_empresa, cnpj_fornecedor, cep_fornecedor, num_fornecedor, telefone_fornecedor, email_fornecedor, senha_fornecedor) 
            VALUES ('$nomeEmpresa', '$cnpj', '$cep', '$numeroendereco', '$telefone', '$email', '$senha_cripto')";
    
    if ($conn->query($sql) === TRUE) {
        // Redireciona para login.php após o cadastro bem-sucedido
        header("Location: logincacambeiro.php");
        exit(); // Para garantir que o script seja interrompido após o redirecionamento
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
