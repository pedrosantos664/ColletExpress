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
	<link rel="stylesheet" href="css/styles - cadastro.css">

	<style>
        .custom-select select {
            appearance: none;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 10px;
            font-size: 20px;
            width: 100%;
            box-sizing: border-box;
        }

        .custom-select select:focus {
            border-color: #black;
            outline: none;
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
		<section class="form-section-tpo-usuario">
			<h2>Primeiro Passo</h2>
			<div class="custom-select">
				<form id="cadastroForm" class="cadastro" name="form1" method="post">
					<select id="tipo" name="tipo" required onchange="redirecionar()">
						<option value="" disabled selected>Selecione um tipo de cadastro</option>
						<option value="cliente">Cliente</option>
						<option value="cacamba">Caçamba</option>
					</select>
				</form>
			</div>
		</section>
	</main>
	<footer class="footer_pre">
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
	<script>
		function redirecionar() {
			const select = document.getElementById('tipo');
			const valorSelecionado = select.value;
		
			let url;
			if (valorSelecionado === 'cliente') {
				url = 'ccliente.php'; // URL para Cliente
			} else if (valorSelecionado === 'cacamba') {
				url = 'ccacambeiro.php'; // URL para Caçambeiro
			}
		
			if (url) {
				window.location.href = url; // Redireciona para a URL correspondente
			}
		}
		</script>
</body>

</html>