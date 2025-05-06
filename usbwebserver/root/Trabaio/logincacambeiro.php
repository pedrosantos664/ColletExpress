<?php
// Inclua a conexão ao banco de dados
include 'conexao.php';

// Variável para armazenar a mensagem de erro
$login_error = "";

// Verifique se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura os dados do formulário
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // Criptografa a senha usando md5() para comparação (não recomendado para produção)
    $senha_md5 = md5($senha);

    // Consulta o banco de dados para verificar o e-mail
    $sql = "SELECT * FROM tb_fornecedor WHERE email_fornecedor='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // O e-mail existe, agora verifica a senha
        $row = $result->fetch_assoc();
        $senha_armazenada = $row['senha_fornecedor']; // Senha armazenada no banco

        // Verifica se a senha inserida corresponde à armazenada
        if ($senha_md5 == $senha_armazenada) {
            // Login bem-sucedido
            session_start();
            $_SESSION['usuario'] = $row['email_fornecedor']; // Armazena o e-mail do usuário na sessão
            $_SESSION['id_fornecedor'] = $row['id_fornecedor']; // Armazena o ID do fornecedor na sessão
            $_SESSION['nome_empresa'] = $row['nome_empresa'];

            // Redireciona para a página inicial
            header("Location: index.php");
            exit();
        } else {
            // Senha incorreta
            $login_error = "Email ou Senha incorretos!";
        }
    } else {
        // E-mail não encontrado
        $login_error = "Email ou Senha incorretos!";
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
            <form id="loginForm" method="POST" action="logincacambeiro.php">
                <label for="email">EMAIL:</label>
                <input type="email" id="email" name="email" required>
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
