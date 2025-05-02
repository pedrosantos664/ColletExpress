<?php 
// Inclua a conexão ao banco de dados
include 'conexao.php';
// Iniciar a sessão
session_start();

// Verificar se o usuário está logado pelo e-mail
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Captura o e-mail do usuário logado a partir da sessão
$email_logado = $_SESSION['usuario'];

// Consulta para pegar o ID do fornecedor a partir do e-mail
$sql_id_fornecedor = "SELECT id_fornecedor FROM tb_fornecedor WHERE email_fornecedor = ?";
$stmt = $conn->prepare($sql_id_fornecedor);
$stmt->bind_param("s", $email_logado);
$stmt->execute();
$result_id_fornecedor = $stmt->get_result();

if ($result_id_fornecedor->num_rows > 0) {
    $fornecedor_data = $result_id_fornecedor->fetch_assoc();
    $id_fornecedor = $fornecedor_data['id_fornecedor'];
} else {
    echo "<p>Erro: Dados do fornecedor não encontrados.</p>";
    exit();
}

// Consulta para buscar os dados do fornecedor logado
$sql = "SELECT email_fornecedor, cnpj_fornecedor, cep_fornecedor, num_fornecedor, telefone_fornecedor 
        FROM tb_fornecedor 
        WHERE email_fornecedor = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email_logado);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $fornecedor = $result->fetch_assoc();
} else {
    echo "<p>Erro: Dados do fornecedor não encontrados.</p>";
    exit();
}

// Consulta para buscar as caçambas do fornecedor logado
$sql_cacambas = "SELECT * FROM tb_cacambas WHERE id_fornecedor = ?";
$stmt = $conn->prepare($sql_cacambas);
$stmt->bind_param("i", $id_fornecedor);
$stmt->execute();
$result_cacambas = $stmt->get_result();
$cacambas = $result_cacambas->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Fornecedor - CollectExpress</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/styles-perfil.css">
    <style>
        /* Estilo para o perfil e formulário */
        .container_perfil {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .perfil-lista {
            list-style-type: none;
            padding: 0;
            font-family: Arial, sans-serif;
            width: 100%;
            max-width: 600px;
        }

        .perfil-lista li {
            background-color: #f4f4f4;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
        }

        .perfil-lista li strong {
            font-weight: bold;
            color: #333;
        }

        /* Botões */
        button {
            padding: 15px 30px;
            font-size: 18px;
            margin: 10px 0;
            cursor: pointer;
            border-radius: 8px;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-editar {
            background-color: #4CAF50;
            color: white;
            width: 200px;
        }

        .btn-editar:hover {
            background-color: #45a049;
        }

        /* Estilos do grid de caçambas */
        .cacambas-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px; /* Espaçamento entre os cartões */
        }

        .cacamba-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            width: 250px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .cacamba-card {
            padding: 10px;
            margin: 15px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
        }

        .cacamba-card img {
            width: 100%;
            max-width: 200px;
            height: auto;
            margin-bottom: 10px;
        }

        .cacamba-info p {
            margin-bottom: 8px;
        }

        .cacamba-card img {
            width: 200px; /* Largura fixa para as imagens */
            height: 150px; /* Altura fixa para as imagens */
            object-fit: cover; /* Ajusta a imagem para cobrir o espaço sem distorcer */
            margin-bottom: 10px;
            border-radius: 5px; /* Bordas arredondadas (opcional) */
        }

        .btn-actions {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .btn-salvar,
        .btn-deletar {
            padding: 10px 20px;
            font-size: 14px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-salvar {
            background-color: #28a745;
            color: #fff;
        }

        .btn-deletar {
            background-color: #dc3545;
            color: #fff;
        }

        /* Estilo para os modais */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        /* Aumenta o padding interno do modal */
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 30px; /* Aumente o padding para dar mais espaço no conteúdo do modal */
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
        }

        /* Ajuste os campos de entrada nos formulários dentro dos modais */
        .modal-content form label,
        .modal-content form input,
        .modal-content form select {
            display: block;
            width: 100%;
            margin-bottom: 15px; /* Aumenta o espaço entre os campos */
        }

        .modal-content form input {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* Espaçamento entre o título e os campos */
        .modal-content h2 {
            margin-bottom: 20px;
        }

        /* Espaçamento entre o conteúdo do modal e a borda */
        .modal-content .close {
            margin-top: -10px; /* Ajuste o close para ter um pequeno espaçamento em cima */
            padding-right: 10px;
        }


        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Responsividade para telas menores */
        @media (max-width: 600px) {
            .cacambas-grid {
                grid-template-columns: 1fr;
            }
            button {
                width: 100%;
            }
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
        <img src="imagens/logo.png" id="logo" width="auto" height="60" alt="Logo CollectExpress">
        <div class="menu">
            <ul>
                <li><a href="index.php">Início</a></li>
                <li><a href="servicos.php">Serviços</a></li>
                <li><a href="ccacamba.php">Cadastrar Caçamba</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </div>
    </nav>
</header>

<main>
    <div class="container_perfil">
        <h2>Dados do Fornecedor</h2>
        
        <ul class="perfil-lista">
            <li><strong>Email:</strong> <?php echo $fornecedor['email_fornecedor']; ?></li>
            <li><strong>CNPJ:</strong> <?php echo $fornecedor['cnpj_fornecedor']; ?></li>
            <li><strong>CEP:</strong> <?php echo $fornecedor['cep_fornecedor']; ?></li>
            <li><strong>Telefone:</strong> <?php echo $fornecedor['telefone_fornecedor']; ?></li>
            <li><strong>Endereço:</strong> <?php echo $fornecedor['num_fornecedor']; ?></li>
        </ul>
        
        <button type="button" class="btn-editar" onclick="openEditPerfilModal()">Editar Perfil</button>

        <!-- Modal de Edição do Fornecedor -->
        <div id="editPerfilModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeEditPerfilModal()">&times;</span>
                <h2>Editar Dados do Fornecedor</h2>
                <form action="editar_fornecedor.php" method="POST">
                    <label for="email_fornecedor">Email:</label>
                    <input type="email" name="email_fornecedor" id="email_fornecedor" value="<?php echo $fornecedor['email_fornecedor']; ?>" required>
                    <label for="cnpj_fornecedor">CNPJ:</label>
                    <input type="text" name="cnpj_fornecedor" id="cnpj_fornecedor" value="<?php echo $fornecedor['cnpj_fornecedor']; ?>" required>
                    <label for="cep_fornecedor">CEP:</label>
                    <input type="text" name="cep_fornecedor" id="cep_fornecedor" value="<?php echo $fornecedor['cep_fornecedor']; ?>" required>
                    <label for="telefone_fornecedor">Telefone:</label>
                    <input type="text" name="telefone_fornecedor" id="telefone_fornecedor" value="<?php echo $fornecedor['telefone_fornecedor']; ?>" required>
                    <label for="num_fornecedor">Endereço:</label>
                    <input type="text" name="num_fornecedor" id="num_fornecedor" value="<?php echo $fornecedor['num_fornecedor']; ?>" required>
                    <button type="submit" class="btn-salvar">Salvar Alterações</button>
                </form>
            </div>
        </div>

        <!-- Modal de Edição de Caçamba -->
        <div id="editCacambaModal" class="modal">
            <div class="modal-content">
            <span class="close" onclick="closeEditCacambaModal()">&times;</span>
                <h2>Editar Caçamba</h2>
                <form action="editar_cacamba.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_cacamba" id="id_cacamba">
                    
                    <!-- Campo Nome da Empresa -->
                    <label for="nome_empresa">Nome da Empresa:</label>
                    <input type="text" name="nome_empresa" id="nome_empresa" required>

                        <!-- Campo Tipo de Caçamba -->
                    <label for="tipo_cacamba">Tipo de Caçamba:</label>
                    <div class="custom-select">
                        <select id="tipo_cacamba" name="tipo_cacamba" required>
                            <option value="" disabled selected>Selecione...</option>
                            <option value="Grande">Grande</option>
                            <option value="Média">Média</option>
                            <option value="Pequena">Pequena</option>
                        </select>
                    </div>
                    
                        <!-- Campo Capacidade da Caçamba -->
                    <label for="capacidade_cacamba">Capacidade (m³):</label>
                    <div class="custom-select">
                        <select id="capacidade_cacamba" name="capacidade_cacamba" required>
                            <option value="" disabled selected>Selecione...</option>
                            <option value="3">3m³</option>
                            <option value="4">4m³</option>
                            <option value="5">5m³</option>
                            <option value="6">6m³</option>
                            <option value="7">7m³</option>
                        </select>
                    </div>

                        <!-- Campo Status da Caçamba -->
                    <label for="status_cacamba">Status:</label>
                    <div class="custom-select">
                        <select id="status_cacamba" name="status_cacamba" required>
                            <option value="" disabled selected>Selecione...</option>
                            <option value="1">Alugada</option>
                            <option value="0">Disponível</option>
                        </select>
                    </div>
                    <!-- Campo Preço de Aluguel -->
                    <label for="preco_aluguel_cacamba">Preço de Aluguel (R$):</label>
                    <input type="text" name="preco_aluguel_cacamba" id="preco_aluguel_cacamba" required>

                    <!-- Campo de Imagem -->
                    <label for="imagem_cacamba">Imagem da Caçamba:</label>
                    <input type="file" name="imagem_cacamba" id="imagem_cacamba">

                    <button type="submit" class="btn-salvar">Salvar Alterações</button>
                </form>
            </div>
        </div>



        <!-- Grid de caçambas -->
        <h3>Caçambas Registradas</h3>
        <div class="cacambas-grid">
    <?php foreach ($cacambas as $cacamba): ?>
        <div class="cacamba-card">
            <?php if (!empty($cacamba['imagem_cacamba'])): ?>
                <!-- Exibe a imagem diretamente do banco de dados -->
                <img src="<?php echo $cacamba['imagem_cacamba']; ?>" alt="Imagem da Caçamba">
            <?php else: ?>
                <img src="imagens/placeholfdder.png" alt="Imagem não disponível">
            <?php endif; ?>
            <div class="cacamba-info">
                <p><strong>ID:</strong> <?php echo $cacamba['id_cacamba']; ?></p>
                <p><strong>Tipo:</strong> <?php echo $cacamba['tipo_cacamba']; ?></p>
                <p><strong>Capacidade:</strong> <?php echo $cacamba['capacidade_cacamba']; ?> m³</p>
                <p><strong>Status:</strong>
                    <?php 
                    // Verificar o status e exibir "Disponível" ou "Alugada"
                    echo $cacamba['status_cacamba'] == 0 ? 'Disponível' : 'Alugada'; 
                    ?>
                </p>
                <p><strong>Preço (por dia):</strong> R$<?php echo $cacamba['preco_aluguel_cacamba']; ?></p>
            </div>
            <div class="btn-actions">
                <button onclick="openEditCacambaModal(<?php echo $cacamba['id_cacamba']; ?>)" class="btn-salvar">Editar</button>
                <a href="deletar_cacamba.php?id=<?php echo $cacamba['id_cacamba']; ?>" >
                    <button onclick="return confirm('Tem certeza que deseja excluir esta caçamba?')" class="btn-deletar">Excluir</button>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>


    </div>
</main>

<script>
    // Função para abrir o modal de edição de perfil
    function openEditPerfilModal() {
        document.getElementById('editPerfilModal').style.display = 'block';
    }

    // Função para fechar o modal de edição de perfil
    function closeEditPerfilModal() {
        document.getElementById('editPerfilModal').style.display = 'none';
    }
    // Função para fechar o modal
    function closeEditCacambaModal() {
        document.getElementById('editCacambaModal').style.display = 'none';
    }


    // Função para abrir o modal de edição de caçamba
    function openEditCacambaModal(idCacamba) {
        // Fazer uma requisição AJAX para buscar os dados da caçamba
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "get_cacamba.php?id_cacamba=" + idCacamba, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Recebe os dados da caçamba
                var data = JSON.parse(xhr.responseText);
                
                if (data.error) {
                    alert(data.error);
                } else {
                    // Preenche os campos do modal com os dados da caçamba
                    document.getElementById('id_cacamba').value = data.id_cacamba;
                    document.getElementById('tipo_cacamba').value = data.tipo_cacamba;
                    document.getElementById('capacidade_cacamba').value = data.capacidade_cacamba;
                    document.getElementById('status_cacamba').value = data.status_cacamba;
                    document.getElementById('preco_aluguel_cacamba').value = data.preco_aluguel_cacamba;
                    document.getElementById('nome_empresa').value = data.nome_empresa;
                    // Não é necessário preencher a imagem diretamente, pois ela é enviada pelo formulário
                    // Exibe o modal
                    document.getElementById('editCacambaModal').style.display = 'block';
                }
            } else {
                alert('Erro ao carregar dados da caçamba.');
            }
        };
        xhr.send();
    }


</script>

</body>
</html>
