<?php
// Iniciar a sessão para usar as mensagens de notificação
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CollectExpress</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/styles - cacambas.css">
    <style>
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border-radius: 5px;
            display: none;
            z-index: 1000;
            font-size: 24px;
            margin-top: 55px;
        }
        .notification.error {
            background-color: #f44336;
        }

        .form-section{
            margin-bottom: 150px;
        }

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
    <section class="form-section">
        <h2>Cadastro de Caçambas</h2>
        <form id="cadastroForm" method="POST" action="cadastrar_cacamba.php" enctype="multipart/form-data">
            <label for="imagem_cacamba">Selecione uma imagem:</label>
            <input type="file" name="imagem_cacamba" id="imagem_cacamba" accept="image/*" required>

            <div class="custom-select">
                <label for="tipocacamba">Tipo de caçamba:</label>
                <select id="tipocacamba" name="tipocacamba" required>
                    <option value="" disabled selected>Selecione...</option>
                    <option value="Grande">Grande</option>
                    <option value="Média">Média</option>
                    <option value="Pequena">Pequena</option>
                </select>

                <label for="capacidade">Capaciade da caçamba(em m³):</label>
                <select id="capacidade" name="capacidade" required>
                    <option value="" disabled selected>Selecione...</option>
                    <option value="3">3m³</option>
                    <option value="4">4m³</option>
                    <option value="5">5m³</option>
                    <option value="6">6m³</option>
                    <option value="7">7m³</option>
                </select>
            </div>
            <label for="preco">Preço do aluguel (por dia):</label>
            <input type="text" id="preco" name="preco" required>

            <button type="submit" class="btn">Cadastrar</button>
        </form>
    </section>
</main>

    <!-- Elemento de notificação -->
    <div id="notification" class="notification"></div>

    <script>
        // Exibir a notificação se houver uma mensagem na sessão
        document.addEventListener("DOMContentLoaded", function() {
            <?php if (isset($_SESSION['message'])): ?>
                // Exibir a notificação com a mensagem do PHP
                const notification = document.getElementById("notification");
                notification.textContent = "<?php echo $_SESSION['message']; ?>";
                notification.classList.add("<?php echo $_SESSION['message_type']; ?>");
                notification.style.display = "block";
                
                // Limpar a sessão para evitar mensagens duplicadas
                <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>

                // Fechar a notificação após 3 segundos e limpar o formulário
                setTimeout(() => {
                    notification.style.display = "none";
                    document.getElementById("cadastroForm").reset();
                }, 3000);
            <?php endif; ?>
        });
    </script>

    <footer >
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
