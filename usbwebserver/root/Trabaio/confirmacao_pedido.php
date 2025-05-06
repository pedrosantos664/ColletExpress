<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Finalizado</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<style>
    .pedido_finalizado-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
    }
    .div_espaco {
        height: 150px;
    }
</style>
<body>
    <header>
        <nav>
            <img src="imagens/logo.png" id="logo" width="auto" height="60">
            <div class="menu">
                <ul>
                    <li><a href="index.php">Início</a></li>
                    <li><a href="servicos.php">Serviços</a></li>
                    <li><a href="logout.php">Sair</a></li> <!-- Link para logout -->
                </ul>
            </div>
        </nav>
    </header>
    <div class="pedido_finalizado-container">
        <div>
        <h1>Seu pedido foi finalizado com sucesso!</h1>
        <h2>Obrigado pelo seu pedido. Você receberá mais informações por e-mail.</h2>
        <h3>Volte para a página inicial</h3>
        </div>
    </div>
    <div class="div_espaco"></div>
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
