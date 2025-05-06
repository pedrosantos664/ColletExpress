<?php 
// Iniciar a sessão
session_start();

// Verificar se o usuário está logado, caso contrário redirecionar para a página de login
if (!isset($_SESSION['cpf'])) {
    header("Location: login.php");
    exit();
}

// Inclua a conexão ao banco de dados
include 'conexao.php';

// Captura o CPF do usuário logado a partir da sessão
$cpf_logado = $_SESSION['cpf'];

// Verifica se o formulário foi enviado para atualizar os dados
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['salvar'])) {
    $nome = $_POST['nome'];
    $cep = $_POST['cep'];
    $num_casa = $_POST['num_casa'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    
    // Atualiza os dados no banco
    $sql_update = "UPDATE tb_cliente 
                   SET nome_cliente='$nome', cep_cliente='$cep', num_casa_cliente='$num_casa', telefone_cliente='$telefone', email_cliente='$email' 
                   WHERE cpf_cliente='$cpf_logado'";
    
    if ($conn->query($sql_update) === TRUE) {
        echo "<script>alert('Dados atualizados com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao atualizar os dados: " . $conn->error . "');</script>";
    }
}

// Verifica se o botão de exclusão foi pressionado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deletar'])) {
    $sql_delete = "DELETE FROM tb_cliente WHERE cpf_cliente='$cpf_logado'";
    
    if ($conn->query($sql_delete) === TRUE) {
        // Destrói a sessão e redireciona para a página de login
        session_destroy();
        header("Location: login.php");
        exit();
    } else {
        echo "<script>alert('Erro ao excluir o perfil: " . $conn->error . "');</script>";
    }
}

// Consulta para buscar os dados do cliente logado
$sql = "SELECT id_cliente, nome_cliente, cpf_cliente, cep_cliente, num_casa_cliente, telefone_cliente, email_cliente FROM tb_cliente WHERE cpf_cliente = '$cpf_logado'";
$result = $conn->query($sql);

// Verifica se encontrou o registro do cliente
if ($result->num_rows > 0) {
    $cliente = $result->fetch_assoc();
} else {
    // Caso nenhum dado seja encontrado, exibe mensagem de erro
    echo "<p>Erro: Dados do cliente não encontrados.</p>";
    exit();
}

// Agora, usamos o id_cliente recuperado para buscar as caçambas
$id_cliente = $cliente['id_cliente']; // Obtém o id_cliente do cliente logado

// Consulta para buscar as caçambas do cliente logado, incluindo os dados solicitados
$sql_cacambas = "SELECT endereco, numero, opcao_pagamento, tempo_aluguel, data_aluguel
                 FROM tb_cacamba_alugada
                 WHERE id_cliente = '$id_cliente'"; // Usando $id_cliente da consulta anterior
$result_cacambas = $conn->query($sql_cacambas);

// Verifica se há resultados
if ($result_cacambas->num_rows > 0) {
    $cacambas = $result_cacambas->fetch_all(MYSQLI_ASSOC);
} else {
    $cacambas = []; // Se não houver caçambas, um array vazio
}

?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Cliente - CollectExpress</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/styles-perfil.css"> <!-- Adapte seu CSS aqui -->
    <style>
        .perfil-lista {
            list-style: none;
            padding: 0;
        }

        .perfil-lista li {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            margin-right: 10px;
        }

        input {
            padding: 5px;
            width: 300px;
            margin-top: 15px;
        }

        button {
            padding: 10px 20px;
            margin-top: 20px;
            cursor: pointer;
        }

        .btn-salvar {
            background-color: #4CAF50;
            color: white;
            border: none;
            margin-right: 10px;
        }

        .btn-deletar {
            background-color: #f44336;
            color: white;
            border: none;
        }

        .btn-salvar:hover, .btn-deletar:hover {
            opacity: 0.8;
        }
        /* Estilos do grid de caçambas */
        .cacambas-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px; /* Espaçamento entre os cartões */
            justify-content: center; /* Centraliza os itens horizontalmente */
            align-items: center; /* Centraliza os itens verticalmente */
            margin-top: 20px;
        }

        .cacamba-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            width: 300px; /* Largura fixa para as caçambas */
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center; /* Garante que o conteúdo dentro do card seja centralizado */
            margin: 10px; /* Espaçamento entre os cards */
        }
        h3 {
            text-align: center; /* Centraliza o texto do título */
            margin-bottom: 20px; /* Espaço abaixo do título */
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
                <li><a href="logout.php">Sair</a></li> <!-- Link para logout -->
            </ul>
        </div>
    </nav>
</header>

<main>
    <div class="container_perfil">
        <h2>Dados do Cliente</h2>
        <br>
        <form method="POST" action="">
            <ul class="perfil-lista">
                <li>
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" value="<?php echo $cliente['nome_cliente']; ?>" required>
                </li>
                <li>
                    <label for="cpf">CPF:</label>
                    <input type="text" id="cpf" name="cpf" value="<?php echo $cliente['cpf_cliente']; ?>" readonly>
                </li>
                <li>
                    <label for="cep">CEP:</label>
                    <input type="text" id="cep" name="cep" value="<?php echo $cliente['cep_cliente']; ?>" required>
                </li>
                <li>
                    <label for="num_casa">Número da Casa:</label>
                    <input type="text" id="num_casa" name="num_casa" value="<?php echo $cliente['num_casa_cliente']; ?>" required>
                </li>
                <li>
                    <label for="telefone">Telefone:</label>
                    <input type="text" id="telefone" name="telefone" value="<?php echo $cliente['telefone_cliente']; ?>" required>
                </li>
                <li>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $cliente['email_cliente']; ?>" required>
                </li>
            </ul>

            <!-- Botões para salvar e deletar -->
            <button type="submit" class="btn-salvar" name="salvar">Salvar Alterações</button>
            <button type="submit" class="btn-deletar" name="deletar">Excluir Perfil</button>
        </form>
    </div>

    <!-- Grid de caçambas -->
    <h3>Suas Caçambas Alugadas</h3>
    <div class="cacambas-grid">
        <?php foreach ($cacambas as $cacamba): ?>
            <div class="cacamba-card">
                <div class="cacamba-info">
                    <p><strong>Endereço:</strong> <?php echo $cacamba['endereco']; ?></p>
                    <p><strong>Número do Endereço:</strong> <?php echo $cacamba['numero']; ?></p>
                    <p><strong>Opção de Pagamento:</strong> 
                        <?php echo $cacamba['opcao_pagamento'] ? $cacamba['opcao_pagamento'] : 'Cartão de crédito'; ?>
                    </p>
                    <p><strong>Tempo de Aluguel:</strong> <?php echo $cacamba['tempo_aluguel']; ?> dias</p>
                    <p><strong>Data de Aluguel:</strong> <?php echo $cacamba['data_aluguel']; ?></p> 
                </div>
            </div>
        <?php endforeach; ?>
    </div>

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

<?php 
// Fecha a conexão com o banco de dados
$conn->close();
?>
