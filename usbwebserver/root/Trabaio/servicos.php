<?php
// Iniciar a sessão
session_start();
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviços - CollectExpress®</title>
    <link rel="stylesheet" href="css/styles.css">
	<link rel="stylesheet" href="css/styles - servicos.css">
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
    <main>
        <center>
            <section class="services-section">
                <h2 id="serviçosdisponiveis">Serviços Disponíveis</h2>
                <div id="servicosList"><!-- Lista de serviços será gerada aqui -->
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const servicosList = document.getElementById('servicosList');

                            if (servicosList) {
                                const servicos = [
                                    { nome: 'Remoção de Entulho', localizacao: 'São Paulo', preco: 'R$ 200' },
                                    { nome: 'Remoção de Resíduos', localizacao: 'Rio de Janeiro', preco: 'R$ 250' },
                                    { nome: 'Serviços de Limpeza de Terrenos', localizacao: 'Rio de Janeiro', preco: 'R$ 250' },
                                    { nome: 'Transporte de Materiais Pesados', localizacao: 'Rio de Janeiro', preco: 'R$ 300' },
                                    { nome: 'Serviços para Obras e Construção', localizacao: 'São Paulo', preco: 'R$ 400' },
                                    { nome: 'Descarte de Móveis e Eletrodomésticos', localizacao: 'São Paulo', preco: 'R$ 300' },
                                    { nome: 'Remoção de Vegetação e Podas', localizacao: 'São Paulo', preco: 'R$ 200' },
                                    { nome: 'Serviços de Emergência', localizacao: 'Rio de Janeiro', preco: 'R$ 400' },
                                ];

                                // Seleciona o container onde os serviços serão inseridos
                                const container = document.getElementById('servicosList');

                                servicos.forEach(servico => {
                                    // Cria um elemento para cada serviço
                                    const servicoDiv = document.createElement('div');
                                    servicoDiv.classList.add('servico-item');

                                    // Define o conteúdo do elemento
                                    servicoDiv.innerHTML = `
                                        <h3 class="servico-nome">${servico.nome}</h3>
                                        <p class="servico-localizacao">${servico.localizacao}</p>
                                        <p class="servico-preco">${servico.preco}</p>
                                    `;

                                    // Adiciona o elemento ao container
                                    container.appendChild(servicoDiv);
                                });
                            }
                        });
                    </script>
                </div>
            </section>
        </center>


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
