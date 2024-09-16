document.addEventListener('DOMContentLoaded', function() {
    const cadastroForm = document.getElementById('cadastroForm');
    const servicosList = document.getElementById('servicosList');

    if (cadastroForm) {
        cadastroForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(cadastroForm);
            const data = Object.fromEntries(formData.entries());
            console.log('Cadastro:', data);
            alert('Cadastro realizado com sucesso!');
            cadastroForm.reset();
        });
    }

    if (servicosList) {
        const servicos = [
            { nome: 'Remoção de Entulho', localizacao: 'São Paulo', preco: 'R$ 200' },
            { nome: 'Remoção de Resíduos', localizacao: 'Rio de Janeiro', preco: 'R$ 250' },
        ];

        servicos.forEach(servico => {
            const servicoItem = document.createElement('div');
            servicoItem.classList.add('servico-item');
            servicoItem.innerHTML = `
                <h3>${servico.nome}</h3><p>Localização: ${servico.localizacao}</p><p>Preço: ${servico.preco}</p>
            `;
            servicosList.appendChild(servicoItem);
        });
    }
});
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');

    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const cpf = document.getElementById('cpf').value;
            const senha = document.getElementById('senha').value;

            // Remove pontuação do CPF
            const cpfClean = cpf.replace(/[^\d]/g, '');

            // Validação do CPF
            if (!isValidCPF(cpfClean)) {
                alert('Por favor, insira um CPF válido.');
                return;
            }

            // Simulação de verificação na base de dados
            const cpfExists = checkCPFInDatabase(cpfClean);
            if (!cpfExists) {
                alert('CPF não encontrado na base de dados.');
                return;
            }

            // Aqui você pode adicionar a lógica para autenticar o usuário
            console.log('Login:', { cpf: cpfClean, senha });
            alert('Login realizado com sucesso!');
            loginForm.reset();
        });
    }

    function isValidCPF(cpf) {
        if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) {
            return false;
        }
        let sum = 0;
        let remainder;
        for (let i = 1; i <= 9; i++) {
            sum += parseInt(cpf.substring(i - 1, i)) * (11 - i);
        }
        remainder = (sum * 10) % 11;
        if (remainder === 10 || remainder === 11) {
            remainder = 0;
        }
        if (remainder !== parseInt(cpf.substring(9, 10))) {
            return false;
        }
        sum = 0;
        for (let i = 1; i <= 10; i++) {
            sum += parseInt(cpf.substring(i - 1, i)) * (12 - i);
        }
        remainder = (sum * 10) % 11;
        if (remainder === 10 || remainder === 11) {
            remainder = 0;
        }
        if (remainder !== parseInt(cpf.substring(10, 11))) {
            return false;
        }
        return true;
    }

    function checkCPFInDatabase(cpf) {
        // Simulação de uma base de dados de CPFs
        const database = ['12345678909', '98765432100', '11122233344'];
        return database.includes(cpf);
    }
});