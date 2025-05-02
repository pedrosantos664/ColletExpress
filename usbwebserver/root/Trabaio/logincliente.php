<?php
session_start();
include 'conexao.php';

$login_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cpf = $_POST["cpf"];
    $senha = $_POST["senha"];

    // Proteção contra SQL Injection
    $cpf = $conn->real_escape_string($cpf);
    $senha = $conn->real_escape_string($senha);

    // Criptografa a senha usando md5() para comparação (não recomendado para produção)
    $senha_md5 = md5($senha);

    // Consulta ao banco de dados para verificar o CPF
    $sql = "SELECT * FROM tb_cliente WHERE cpf_cliente='$cpf'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Verifica a senha
        $row = $result->fetch_assoc();
        $senha_armazenada = $row['senha_cliente']; 

        if ($senha_md5 == $senha_armazenada) {
            // Login bem-sucedido
            $_SESSION['usuario'] = $row['nome_cliente']; // Nome do usuário
            $_SESSION['cpf'] = $row['cpf_cliente']; // Armazena o CPF na sessão
            $_SESSION['id_cliente'] = $row['id_cliente']; // Armazena o id_cliente na sessão

            // Redireciona para a página inicial após o login
            header("Location: index.php");
            exit();
        } else {
            $login_error = "CPF ou Senha incorretos!";
        }
    } else {
        $login_error = "CPF ou Senha incorretos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CollectExpress</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/styles-login.css">
</head>
<body>

<header>
    <nav>
		<img src="imagens/logo.png" id="logo" width="auto" height="60">
		<div class="menu">
			<ul>
				<li><a href="index.php">Início</a></li>
				<li><a href="servicos.php">Serviços</a></li>
				<li><a href="login.php">Login</a></li>
				<li><a href="cadastro.php">Cadastro</a></li>
				<li><a href="cacambas.php">Caçambas</a></li>
			</ul>
		</div>
    </nav>
</header>

<main>
    <div class="container_login">
        <section class="form-section">
            <h2>Login</h2>
            <form id="loginForm" method="POST" action="logincliente.php">
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" required placeholder="000.000.000-00">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
                <button type="submit" class="btn">Entrar</button>
                <?php if ($login_error): ?>
    <p style="color: red;"><?php echo $login_error; ?></p>
<?php endif; ?>
            </form>
        </section>
    </div>
</main>

<footer>
	<div class="footer_content">
		<div>
			<h3>CONTATO</h3>
			<ul>
				<li>collectexpress.app@outlook.com</li>
				<li>collectexpress_instagram</li>
				<li>collectexpress_tiktok</li>
				<li>collectexpress_seilaoq</li>
				<li>(11) 99999-9999</li>
			</ul>
		</div>

		<div>
			<h3>DESENVOLVEDORES</h3>
			<ul>
				<li>Anna Carolina De Azevedo Leite</li>
				<li>Gabriel de Andrade Ferreira</li>
				<li>Giulia Caroline Claro</li>
				<li>Leonardo Dias Dos Santos</li>
				<li>Pedro Henrique Batista Dos Santos</li>
			</ul>
		</div>

		<div>
			<h3>ACOMPANHE-NOS</h3>
			<ul>
				<li>github.com/annacarolinaa</li>
				<li>github.com/biel388</li>
				<li>github.com/GiuCaroline</li>
				<li>github.com/Leo-Santoss</li>
				<li>github.com/pedrosantos664</li>
			</ul>
		</div>
	</div>

	<p>
		CollectExpress® 2024
	</p>
</footer>



</body>
</html>
