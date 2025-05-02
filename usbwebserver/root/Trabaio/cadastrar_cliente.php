<?php
// Inclua o arquivo de conexão com o banco de dados
include 'conexao.php';

// Inicialize a variável para armazenar mensagens
$mensagem = "";

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
    $senha_cripto = md5($senha);

    // Verifica se o e-mail já existe
    $sql = "SELECT * FROM tb_cliente WHERE email_cliente = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $mensagem = "CONTA EXISTENTE!!!";
    } else {
        // Insere o novo cliente no banco de dados
        $sql = "INSERT INTO tb_cliente (nome_cliente, cpf_cliente, cep_cliente, num_casa_cliente, telefone_cliente, email_cliente, senha_cliente)
                VALUES ('$nome', '$cpf', '$cep', '$numcasa', '$telefone', '$email', '$senha_cripto')";

        if ($conn->query($sql) === TRUE) {
            $mensagem = "Cadastro realizado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar: " . $conn->error;
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
    <style>
        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            display: none;
        }
        .popup button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
    </style>
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
    <!-- Popup de mensagem -->
    <div id="popup" class="popup">
        <p id="popup-message"></p>
        <button onclick="closePopup()">OK</button>
    </div>

    <script>
        // Mostra o popup com a mensagem, se houver
        document.addEventListener("DOMContentLoaded", function() {
            const mensagem = "<?php echo $mensagem; ?>";
            if (mensagem) {
                const popup = document.getElementById("popup");
                const popupMessage = document.getElementById("popup-message");
                popupMessage.textContent = mensagem;
                popup.style.display = "block";
            }
        });

        // Fecha o popup
        function closePopup() {
            const popup = document.getElementById("popup");
            popup.style.display = "none";
        }
    </script>
</body>
</html>
