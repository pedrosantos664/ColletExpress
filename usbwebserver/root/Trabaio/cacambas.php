<?php
session_start();

include 'conexao.php';

// Verifica se há busca ou não, e se a busca está preenchida
if (isset($_POST['busca_nome']) && $_POST['busca_nome'] != '') {
    // Filtra também pelo status_cacamba para garantir que caçambas com status 1 não apareçam
    $query = "SELECT * FROM tb_cacambas WHERE tipo_cacamba LIKE '{$_POST['busca_nome']}%' AND status_cacamba != 1 ORDER BY preco_aluguel_cacamba ASC";
} else {
    // Filtra também pelo status_cacamba para garantir que caçambas com status 1 não apareçam
    $query = "SELECT * FROM tb_cacambas WHERE status_cacamba != 1";
}

$result = mysqli_query($conn, $query);
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CollectExpress</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/styles - cacambas.css">
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
                <li><a href="carrinho.php">Carrinho</a></li>
               

    </ul>
</div>

			</ul>
		</div>
		<div class="between" style="width: 30%;"></div>
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
    <form name="form1" method="POST" action="cacambas.php" class="container">
        <input type="text" name="busca_nome" placeholder="Digite o tipo da caçamba..." class="pesquisar">
        <button type="submit" class="btn-lupa">
            <img src="imagens/lupa.png" id="lupa" width="30" height="30" alt="Buscar">
        </button>
    </form>

    <section class="product-grid">
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="product-card">
            <!-- Exibindo a imagem armazenada no banco de dados -->
            <img src="<?php echo $row['imagem_cacamba']; ?>" alt="Imagem da Caçamba">
            <h2><?php echo $row['nome_empresa']; ?></h2>
            <p><?php echo $row['tipo_cacamba']; ?></p>
            <p><?php echo $row['capacidade_cacamba']; ?> L</p>
            <span class="preco">R$ <?php echo number_format($row['preco_aluguel_cacamba'], 2, ',', '.'); ?></span>

            <form method="POST" action="adicionar_ao_carrinho.php">
    <input type="hidden" name="id_cacamba" value="<?php echo $row['id_cacamba']; ?>">
    <input type="hidden" name="quantidade" value="1">
    <button type="submit">Adicionar ao Carrinho</button>
</form>

        </div>
    <?php endwhile; ?>
</section>

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
    <p>CollectExpress® 2024</p>
</footer>

</body>
</html>
