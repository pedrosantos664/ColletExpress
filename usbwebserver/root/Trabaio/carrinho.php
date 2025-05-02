<?php
session_start();

// Verificar se o cliente está logado
if (!isset($_SESSION['id_cliente']) && !isset($_SESSION['cpf'])) {
    die("Erro: Usuário não está logado.");
}

// Identificar o cliente logado
$id_cliente = isset($_SESSION['id_cliente']) ? $_SESSION['id_cliente'] : null;
$cpf_cliente = isset($_SESSION['cpf']) ? $_SESSION['cpf'] : null;

// Incluir a conexão com o banco de dados
include 'conexao.php';

// Consultar os itens do carrinho para o cliente logado
$query_carrinho = "SELECT c.id_cacamba, c.quantidade, ca.tipo_cacamba, ca.capacidade_cacamba, ca.preco_aluguel_cacamba, ca.imagem_cacamba
                   FROM tb_carrinho c
                   JOIN tb_cacambas ca ON c.id_cacamba = ca.id_cacamba
                   WHERE c.id_cliente = ?";
$stmt = mysqli_prepare($conn, $query_carrinho);
mysqli_stmt_bind_param($stmt, 'i', $id_cliente);
mysqli_stmt_execute($stmt);
$resultado_carrinho = mysqli_stmt_get_result($stmt);


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
<style>
    .div_espaco {
        height: 50px;
    }

    /* Botão de Resumo */
    .resumo-btn-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
    }

    .resumo-btn {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        width: 500px;
        text-align: center;
    }

    .resumo-btn:hover {
        background-color: #0056b3;
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
    }

    /* Modal Content */
    .modal-content {
        background-color: #ffffff;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        border-radius: 8px;
        width: 80%;
        max-width: 500px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        position: relative;
    }

    /* Estilo para o selectbox */
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
        border-color: black;
        outline: none;
    }

    /* Espaçamento entre os campos */
    .modal-content form label {
        display: block;
        margin-top: 20px; /* Maior espaçamento entre os campos */
        font-size: 16px;
        font-weight: bold;
        color: #333;
    }

    .modal-content form input,
    .modal-content form select {
        margin-top: 10px;
        margin-bottom: 10px;
        padding: 10px;
        font-size: 16px;
        width: 100%;
        border-radius: 5px;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    /* Estilo para o botão de finalizar pedido */
    .finalize-btn {
        margin-top: 20px;
        padding: 12px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 18px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        width: 100%; /* Botão ocupa toda a largura */
        box-sizing: border-box;
    }

    .finalize-btn:hover {
        background-color: #0056b3;
    }

    .modal-content input[type="number"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    /* Close Button */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
    }
    /* Imagem do Pix */
    #pix-modal img {
        margin-bottom: 20px;
    }

    /* Botão para voltar no modal de cartão */
    #back-to-main {
        background-color: #6c757d;
    }

    #back-to-main:hover {
        background-color: #5a6268;
    }

</style>

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
        <div class="between" style="width: 30%;"></div>
        <?php if (isset($_SESSION['usuario'])): ?>
            <div class="perfil-sair">
                <span>Bem-vindo,<br> <?php echo $_SESSION['usuario']; ?></span>
                <a href="<?php echo (strpos($_SESSION['usuario'], '@') !== false) ? 'perfilcacambeiro.php' : 'perfilcliente.php'; ?>">
                    <img src="imagens/perfil.png" id="perfil" width="35" height="35">
                </a>
                <a href="logout.php"><img src="imagens/sair.png" id="sair" width="37" height="37"></a>
            </div>
        <?php endif; ?>
    </nav>
</header>

<main>
    <h1>Meu Carrinho</h1>
    <div class="div_espaco"></div>

    <?php if (mysqli_num_rows($resultado_carrinho) > 0): ?>
        <section class="product-grid">
            <?php while ($row = mysqli_fetch_assoc($resultado_carrinho)): ?>
                <div class="product-card">
                    <img src="<?php echo $row['imagem_cacamba']; ?>" alt="Imagem da Caçamba">
                    <h2><?php echo $row['tipo_cacamba']; ?></h2>
                    <p>Capacidade: <?php echo $row['capacidade_cacamba']; ?> L</p>
                    <p>Quantidade: <?php echo $row['quantidade']; ?></p>
                    <span class="preco">R$ <?php echo number_format($row['preco_aluguel_cacamba'], 2, ',', '.'); ?></span>
                    <form method="POST" action="remover_carrinho.php">
                        <input type="hidden" name="id_cacamba" value="<?php echo $row['id_cacamba']; ?>">
                        <button type="submit">Remover</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </section>

        <!-- Botão para abrir o modal -->
        <div class="resumo-btn-container">
            <button id="open-modal-btn" class="resumo-btn">Resumo</button>
        </div>

        <!-- <button id="open-modal-btn" class="resumo-btn">Resumo</button> -->

        <!-- Modal Principal -->
        <div id="modal" class="modal">
            <div class="modal-content">
                <span id="close-modal-btn" class="close">&times;</span>
                <h2>Resumo do Pedido</h2>
                <form action="finalizar_pedido.php" method="POST">
                    <!-- <label for="payment-method">Forma de Pagamento:</label>
                    <div class="custom-select">
                        <select name="payment_method" id="payment-method" required>
                            <option value="nulo">Selecione uma Opção</option>
                            <option value="credit_card">Cartão de Crédito</option>
                            <!-- <option value="debit_card">Cartão de Débito</option> 
                            <option value="pix">Pix</option>
                        </select>
                    </div> -->

                    <label for="address">Endereço de Entrega:</label>
                    <input type="text" id="address" name="address" placeholder="Digite o endereço completo" required>

                    <label for="number">Número:</label>
                    <input type="text" id="number" name="number" placeholder="Digite o número" required>

                    <label for="days">Quantidade de Dias:</label>
                    <input type="number" id="days" name="days" placeholder="Número de dias de uso" min="1" max="30" required>


                     <!-- Seletor de forma de pagamento -->
                    <label for="opcao_pagamento">Escolha a forma de pagamento:</label>
                    <select name="payment_method" id="opcao_pagamento" required>
                        <option value="nulo">Selecione</option>
                        <option value="Pix">Pix</option>
                        <option value="Cartão de Crédito">Cartão de Crédito</option>
                        <!-- <option value="Cartão de Débito">Cartão de Débito</option> -->
                    </select>

                    <!-- Campos de pagamento do Cartão de Crédito, ocultos por padrão -->
                    <div id="cartao_credito" style="display:none;">
                        <input type="text" name="card_number" placeholder="Número do Cartão">
                        <input type="text" name="card_holder" placeholder="Nome do Titular">
                        <input type="text" name="expiry_date" placeholder="Validade (MM/AA)">
                        <input type="text" name="cvv" placeholder="CVV" >
                    </div>

                    <!-- Imagem do Pix, oculto por padrão -->
                    <div id="pix_image" style="display:none;">
                        <img src="imagens/opcao_pix.jpg" alt="Pix Image" />
                    </div>

                    <button type="submit" class="finalize-btn">Finalizar Pedido</button>
                </form>
            </div>
        </div>

</div>

    <?php else: ?>
        <p>Seu carrinho está vazio. <a href="cacambas.php">Adicione caçambas!</a></p>
    <?php endif; ?>
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
<script>
    // Abrir e fechar o modal
    const openModalBtn = document.getElementById('open-modal-btn');
    const modal = document.getElementById('modal');
    const closeModalBtn = document.getElementById('close-modal-btn');

    openModalBtn.addEventListener('click', () => {
        modal.style.display = 'flex';
    });

    closeModalBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
</script>
<script>
    // Função para exibir ou ocultar campos de acordo com a opção de pagamento
    document.getElementById('opcao_pagamento').addEventListener('change', function() {
    var formaPagamento = this.value;
    
    // Esconder todos os campos de pagamento
    document.getElementById('cartao_credito').style.display = 'none';
    document.getElementById('pix_image').style.display = 'none';

    // Mostrar os campos de acordo com a seleção
    if (formaPagamento == 'Cartão de Crédito' || formaPagamento == 'Cartão de Débito') {
        document.getElementById('cartao_credito').style.display = 'block';
    } else if (formaPagamento == 'Pix') {
        document.getElementById('pix_image').style.display = 'block';
    }
});

</script>

<script>

    

    // Referências aos elementos
    const mainModal = document.getElementById('modal');
    const pixModal = document.getElementById('pix-modal');
    const cardModal = document.getElementById('card-modal');

    const paymentSelect = document.getElementById('payment-method');
    const finalizeButton = document.querySelector('.finalize-btn');

    const closeModalButtons = document.querySelectorAll('.close');
    const pixPaidButton = document.getElementById('pix-paid-btn');
    const backToMainButton = document.getElementById('back-to-main');

    // Abrir os modais de acordo com a seleção
    paymentSelect.addEventListener('change', () => {
        if (paymentSelect.value === 'pix') {
            mainModal.style.display = 'none';
            pixModal.style.display = 'flex';
        } else if (paymentSelect.value === 'credit_card' || paymentSelect.value === 'debit_card') {
            mainModal.style.display = 'none';
            cardModal.style.display = 'flex';
        }
    });

    // Fechar qualquer modal
    closeModalButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            mainModal.style.display = 'none';
            pixModal.style.display = 'none';
            cardModal.style.display = 'none';
        });
    });

    // Voltar para o modal principal ao clicar em "Já Paguei" ou "Voltar"
    pixPaidButton.addEventListener('click', () => {
        pixModal.style.display = 'none';
        mainModal.style.display = 'flex';
    });

    backToMainButton.addEventListener('click', () => {
        cardModal.style.display = 'none';
        mainModal.style.display = 'flex';
    });
</script>


</html>