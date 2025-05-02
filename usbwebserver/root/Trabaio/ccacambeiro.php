<?php
// Iniciar a sessão
session_start();
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
            <section class="form-section"><h2>Cadastro de Caçambeiros</h2>
                <form id="cadastroForm" method="POST" action="cadastrar_cacambeiro.php">
					<label for="nomeEmpresa">Nome da empresa:</label><input type="text" id="nomeEmpresa" name="nomeEmpresa" required>
					<label for="email">Email:</label><input type="email" id="email" name="email" required>
                    <label for="cnpj">CNPJ:</label><input type="text" id="cnpj" name="cnpj" required>
                    <label for="cep">CEP:</label><input type="text" id="cep" name="cep" required>
                    <label for="numero">Número do endereço:</label><input type="text" id="numcasa" name="numcasa" required>
                    <label for="telefone">telefone:</label><input type="text" id="cell" name="telefone" required>
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
