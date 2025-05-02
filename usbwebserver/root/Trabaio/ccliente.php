<?php
// Iniciar a sessão
session_start();
include 'conexao.php'; // Certifique-se de que o caminho está correto

// Inicialize a variável para mensagens
$mensagem = "";
$message_type = "";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Captura os dados do formulário
    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $cep = $_POST["cep"];
    $numcasa = $_POST["numcasa"];
    $telefone = $_POST["telefone"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // Criptografa a senha
    $senha_cripto = md5($senha); // Use password_hash() em produção

    // Verifica se o e-mail já existe
    $sql = "SELECT * FROM tb_cliente WHERE email_cliente='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // E-mail já existente
        $mensagem = "CONTA EXISTENTE!!!";
        $message_type = "error";
    } else {
        // Insere o novo cadastro
        $sql = "INSERT INTO tb_cliente (nome_cliente, cpf_cliente, cep_cliente, num_casa_cliente, telefone_cliente, email_cliente, senha_cliente) 
                VALUES ('$nome', '$cpf', '$cep', '$numcasa', '$telefone', '$email', '$senha_cripto')";

        if ($conn->query($sql) === TRUE) {
            // Redireciona para a página de login após cadastro bem-sucedido
            header("Location: logincliente.php");
            exit();
        } else {
            $mensagem = "Erro ao cadastrar: " . $conn->error;
            $message_type = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cadastro - CollectExpress®</title>
        <link rel="stylesheet" href="css/styles.css">
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
			<div class="between" style="width: 40%;"></div>
			<?php if (isset($_SESSION['usuario'])): ?>
				<div class="perfil-sair">
					<span>Bem-vindo,<br> <?php echo $_SESSION['usuario']; ?></span>
					<a href="<?php echo (strpos($_SESSION['usuario'], '@') !== false) ? 'perfilcacambeiro.php' : 'perfilcliente.php'; ?>">
						<img src="imagens/perfil.png" id="perfil" width="35" height="35">
					</a>
					<img src="imagens/sair.png" id="sair" width="37" height="37">
				</div>
			<?php endif; ?>

            </nav>
        </header>
        <main>
            <section class="form-section">
                <h2>Cadastro de Cliente</h2>
                <form id="cadastroForm" method="POST" action="cadastrar_cliente.php">
                    <label for="nome">Nome:</label><input type="text" id="nome" name="nome" required>
                    <label for="cpf">CPF:</label><input type="text" id="cpf" name="cpf" required>
                    <label for="cep">CEP:</label><input type="text" id="cep" name="cep" required>
                    <label for="numcasa">Número da residência:</label><input type="text" id="numcasa" name="numcasa" required>
                    <label for="cell">Celular/Telefone:</label><input type="text" id="cell" name="telefone" required>
                    <label for="email">Email:</label><input type="email" id="email" name="email" required>
                    <label for="senha">Senha:</label><input type="password" id="senha" name="senha" required>
                    <button type="submit" class="btn">Cadastrar</button>
                </form>
            </section>
            
        </main>
        
        <!-- <script src="js/scripts.js"> -->
        </script>
        
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
