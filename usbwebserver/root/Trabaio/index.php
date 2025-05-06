<?php
// Iniciar a sessão
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CollectExpress</title>
	<link rel="stylesheet" href="css/styles.css">
	<link rel="stylesheet" href="css/styles_index.css">
</head>
<body>

<header> 
	<nav>
		<img src="imagens/logo.png" id="logo" width="auto" height="60">
		<div class="menu">
			<ul>
				<li><a href="index.php">Início</a></li>
				<li><a href="servicos.php">Serviços</a></li>
				<?php if (!isset($_SESSION['usuario'])): ?>
					<li><a href="login.php">Login</a></li>
					<li><a href="cadastro.php">Cadastro</a></li>
				<?php endif; ?>
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
				<a href="logout.php"><img src="imagens/sair.png" id="sair" width="37" height="37" href="logout.php"></a>
			</div>
		<?php endif; ?>
	</nav>
</header>


	<!-- Conteúdo do site -->
	<?php if (!isset($_SESSION['usuario'])): ?>			
	<section class="hero">
		<h2>Conectando Caçambeiros e Clientes</h2>
		<p>Encontre serviços de remoção de entulho de forma fácil e rápida.</p>
		<a href="cadastro.php" class="btn">Cadastre-se Agora</a>
	</section>
	<?php endif; ?>
	<main>
		<!-- Conteúdo principal -->
		<div class="centralizar">
			<div id="collectExpress_Index">
				<p>COLLECT</p>
				<p>EXPRESS</p>
			</div>
			<img src="imagens/caminhao.jpg" id="caminhao" width="650" height="650">
			<div id="vazada">
				<p>COLLECT</p>
				<p>EXPRESS</p>
			</div>

			<div id="descricao_1">
				<p>Acompanhe o status dos seus pedidos em</p>
				<p>tempo real. Com o CollectExpress, você</p>
				<p>sempre sabe onde estão suas caçambas e</p>
				<p>quando elas estarão disponíveis.</p>
			</div>
			<a  href="servicos.php" class="btn-saiba-mais">SAIBA MAIS</a>
		</div>
	</main>

	<p class="oQue">O QUE OFERECEMOS?</p>

	<div class=" container_ofere">
		<img src="imagens/grafico.png" id="grafico" width="100" height="100">
		<div class="conteudo1">
			<p class="titulo">Eficiência Operacional:</p>
			<p class="texto">Acompanhe suas caçambas em<br> tempo real e otimize seus processos.</p>
		</div>
		<img src="imagens/engrenagem.png" id="engrenagem" width="100" height="100">
		<div class="conteudo2">
			<p class="titulo">Transparência e Confiabilidade:</p>
			<p class="texto">Transparência total e pontualidade<br> garantida em cada pedido.</p>
		</div>
		<img src="imagens/relogio.png" id="relogio" width="60" height="60">
		<div class="conteudo3">
			<p class="titulo">Simplicidade no Agendamento:</p>
			<p class="texto">Agende caçambas de forma rápida<br> e sem complicações.</p>
		</div>
	</div>
	<div class="deixeTudo">
		<p class="facil">DEIXE TUDO MAIS FÁCIL<br> COM O 
			<span class="collect">COLLECTEXPRESS</span>
		</p>
	</div>
	
	<p class="textoFacil">Alugue caçambas com praticidade e rapidez. Nossa plataforma facilita todo o processo, desde a solicitação até a coleta, garantindo<br> agilidade, transparência e eficiência. Confie em quem entende suas necessidades e oferece soluções sob medida.<br> Além disso, você acompanha cada etapa em tempo real, com total controle e segurança.</p>

	<p class="nossosServicos">NOSSOS SERVIÇOS</p>

	<div class="carousel">
		<div class="carousel-item">
		  <img src="imagens/cacamba1.png" alt="Imagem 1" class="carousel-img">
		  <h3 class="titulocarrossel">Caçamba para Entulho Pequeno</h3>
		  <p class="conteudocarrossel" style="text-align: left;"> > Ideal para obras menores e reformas residenciais;<br>
										 > Capacidade: 3m³;<br>
										 > Preço a partir de: R$ 150/dia.</p>
		  <button class="cliqueaqui">ALUGAR AGORA</button>
		</div>
		<div class="carousel-item active">
		  <img src="imagens/cacamba2.png" alt="Imagem 2" class="carousel-img"  style = "width: auto; heigth: auto;">
		  <h3 class="titulocarrossel active">Caçamba de Médio Porte</h3>
		  <p class="conteudocarrossel active" style="text-align: left;"> > Perfeita para reformas de médias e demolições parciais;<br>
													> Capacidade: 5m³;<br>
													> Preço a partir de: R$ 200/dia.</p>
		  <button class="cliqueaqui">COMEÇAR</button>
		</div>
		<div class="carousel-item">
		  <img src="imagens/cacamba3.png" alt="Imagem 3" class="carousel-img" style = "width: auto; heigth: auto;">
		  <h3 class="titulocarrossel">Caçamba de Grande Porte</h3>
		  <p class="conteudocarrossel" style="text-align: left;"> > Para grandes obras e projetos de construção;<br>
																	 > Capacidade: 7m³;<br>
																	 > Preço a partir de: R$ 300/dia.</p>
		  <button class="cliqueaqui">SAIBA MAIS</button>
		</div>
	  </div>
	  	
	  <div class="carousel-indicators">
		<span class="dot"></span>
		<span class="dot"></span>
		<span class="dot"></span>
	</div>

	<script src="js/carrosselIndex.js"></script>
</body>

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

</html>
