// Estrutura de dados para armazenar as metas e vendas
const state = {
    metaSemanal: 30000.00, // Meta semanal independente
    metaMensal: 120000.00, // Meta mensal independente
    metaComercial1: 77000.00, // Meta Comercial 1 independente
    metaComercial2: 50000.00, // Meta Comercial 2 independente
    vendas: [],
    diasRestantes: 0, // Será calculado
};

// Mapeamento dos funcionários para seus respectivos departamentos
const departamentos = {
    "Comercial 1": ["Joyce", "Maisa", "Fabi", "Humberto", "Manoel", "Nathaly", "Hilton"],
    "Comercial 2": ["Dani", "Diego", "Aline"]
};

document.addEventListener('DOMContentLoaded', () => {
    carregarEstado();
    calcularDiasRestantes();
    atualizarMetas();
    atualizarVendasPorDepartamento();
    atualizarEquipeGanhando();
    atualizarVendedorDoDia();
});



// Função para formatar o valor em R$
function formatarValor(valor) {
    return `R$ ${valor.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
}

// Função para registrar uma venda
function registrarVenda(vendedor, valor, formaPagamento) {
    const departamento = getDepartamento(vendedor);
    const venda = { vendedor, valor, formaPagamento, departamento, data: new Date().toLocaleDateString('pt-BR') };

    // Atualizando a lista de vendas
    state.vendas.push(venda);

    // Subtrair o valor das metas específicas
    if (departamento === "Comercial 1") {
        state.metaComercial1 -= valor;
    } else if (departamento === "Comercial 2") {
        state.metaComercial2 -= valor;
    }

    state.metaSemanal -= valor;
    state.metaMensal -= valor;

    // Salvar o estado no localStorage e atualizar a interface
    salvarEstado();
    atualizarMetas();
    atualizarVendasPorDepartamento();
    atualizarEquipeGanhando();
    atualizarVendedorDoDia();
    exibirTelaVenda(vendedor, departamento);
}

// Função para identificar o departamento do vendedor
function getDepartamento(vendedor) {
    for (const [departamento, vendedores] of Object.entries(departamentos)) {
        if (vendedores.includes(vendedor)) {
            return departamento;
        }
    }
    return null;
}

// Atualizar vendas na interface
function atualizarMetas() {
    animarTexto('.card-semanal h1', formatarValor(state.metaSemanal));
    animarTexto('#valor-meta-mensal', formatarValor(state.metaMensal));
    animarTexto('#meta-comercial1', formatarValor(state.metaComercial1));
    animarTexto('#meta-comercial2', formatarValor(state.metaComercial2));
}

function animarTexto(selector, novoValor) {
    const elemento = document.querySelector(selector);
    elemento.classList.add('animacao-numero');
    setTimeout(() => {
        elemento.textContent = novoValor;
        elemento.classList.remove('animacao-numero');
    }, 500);
}

function atualizarVendedorDoDia() {
    const hoje = new Date().toLocaleDateString('pt-BR'); // Data de hoje formatada como dd/mm/yyyy
    const vendasHoje = state.vendas.filter(venda => venda.data === hoje);

    // Somar os valores por vendedor
    const vendasPorVendedor = {};

    vendasHoje.forEach(venda => {
        if (!vendasPorVendedor[venda.vendedor]) {
            vendasPorVendedor[venda.vendedor] = 0;
        }
        vendasPorVendedor[venda.vendedor] += venda.valor;
    });

    // Encontrar o vendedor com o maior valor de vendas
    let vendedorTop = null;
    let maiorVenda = 0;

    for (const vendedor in vendasPorVendedor) {
        if (vendasPorVendedor[vendedor] > maiorVenda) {
            maiorVenda = vendasPorVendedor[vendedor];
            vendedorTop = vendedor;
        }
    }

    // Atualizar a interface com o vendedor do dia
    const vendedorDoDiaDiv = document.querySelector('#consultor-do-dia');
    const valorDoDiaDiv = document.querySelector('#valor-vendedor-top');
    if (vendedorTop) {
        vendedorDoDiaDiv.innerHTML = `${vendedorTop}`;
        valorDoDiaDiv.innerHTML = `${formatarValor(maiorVenda)}`;
    } else {
        vendedorDoDiaDiv.innerHTML = 'Top';
        valorDoDiaDiv.innerHTML = 'R$ 0,00';
    }
}

// Determina qual equipe está ganhando e atualiza a UI
function atualizarEquipeGanhando() {
    const vendasCom1 = state.vendas.filter(v => v.departamento === "Comercial 1").reduce((sum, v) => sum + v.valor, 0);
    const vendasCom2 = state.vendas.filter(v => v.departamento === "Comercial 2").reduce((sum, v) => sum + v.valor, 0);

    const equipeGanhandoDiv = document.querySelector('.equipe-ganhando');

    if (vendasCom1 > vendasCom2) {
        equipeGanhandoDiv.style.backgroundColor = '#6800FD';
    } else if (vendasCom2 > vendasCom1) {
        equipeGanhandoDiv.style.backgroundColor = '#FD3C3C';
    } else {
        equipeGanhandoDiv.style.backgroundColor = 'gray';
    }
}
function atualizarVendasPorDepartamento() {
    const com1Container = document.querySelector('.div4 .vendas');
    const com2Container = document.querySelector('.div5 .vendas');

    com1Container.innerHTML = '';
    com2Container.innerHTML = '';

    state.vendas.forEach(venda => {
        const vendaHtml = `
            <div class="card-venda">
                <div class="left-side">
                    <h3>${venda.vendedor}</h3>
                    <span>${venda.formaPagamento}</span>
                </div>
                <div class="right-side">
                    ${formatarValor(venda.valor)}
                </div>
            </div>
        `;
        if (venda.departamento === "Comercial 1") {
            com1Container.innerHTML += vendaHtml;
        } else if (venda.departamento === "Comercial 2") {
            com2Container.innerHTML += vendaHtml;
        }
    });
}
function atualizarEquipeGanhando() {
    const vendasCom1 = state.vendas.filter(v => v.departamento === "Comercial 1").reduce((sum, v) => sum + v.valor, 0);
    const vendasCom2 = state.vendas.filter(v => v.departamento === "Comercial 2").reduce((sum, v) => sum + v.valor, 0);

    const equipeGanhandoDiv = document.querySelector('.equipe-ganhando');

    if (vendasCom1 > vendasCom2) {
        equipeGanhandoDiv.style.backgroundColor = '#6800FD';
    } else if (vendasCom2 > vendasCom1) {
        equipeGanhandoDiv.style.backgroundColor = '#FD3C3C';
    } else {
        equipeGanhandoDiv.style.backgroundColor = 'gray';
    }
}


// Resetar as metas
document.querySelector('.fa-arrow-rotate-left').addEventListener('click', () => {
    if (confirm("Deseja redefinir todas as metas e vendas?")) {
        // Solicitar novas metas ao usuário
        const novaMetaSemanal = parseFloat(prompt("Qual será a nova meta semanal?", "30000.00"));
        const novaMetaMensal = parseFloat(prompt("Qual será a nova meta mensal?", "120000.00"));
        const novaMetaComercial1 = parseFloat(prompt("Qual será a nova meta para o Comercial 1?", "77000.00"));
        const novaMetaComercial2 = parseFloat(prompt("Qual será a nova meta para o Comercial 2?", "50000.00"));

        if (!isNaN(novaMetaSemanal) && !isNaN(novaMetaMensal) && !isNaN(novaMetaDiaria) && !isNaN(novaMetaComercial1) && !isNaN(novaMetaComercial2)) {
            // Atualizar as metas no estado
            state.metaSemanal = novaMetaSemanal;
            state.metaMensal = novaMetaMensal;
            state.metaComercial1 = novaMetaComercial1;
            state.metaComercial2 = novaMetaComercial2;

            // Limpar as vendas
            state.vendas = [];

            // Salvar e atualizar o estado
            salvarEstado();
            atualizarMetas();
            atualizarVendasPorDepartamento();
            atualizarEquipeGanhando();
        } else {
            alert("Por favor, insira valores válidos para todas as metas.");
        }
    }
});

// Resetar as vendas
document.querySelector('.fa-trash-can').addEventListener('click', () => {
    if (confirm("Deseja resetar todas as vendas?")) {
        state.vendas = [];
        salvarEstado();
        atualizarVendasPorDepartamento();
        atualizarEquipeGanhando();
    }
});


// Função para exibir a tela de homenagem ao vendedor
function exibirTelaVenda(vendedor, departamento) {
    const vendaScreen = document.querySelector('.venda-screen');
    const consultorVenda = document.getElementById('consultor-venda');

    consultorVenda.textContent = vendedor;

    if (departamento === "Comercial 1") {
        vendaScreen.style.backgroundColor = '#6800FD';
    } else if (departamento === "Comercial 2") {
        vendaScreen.style.backgroundColor = '#FD3C3C';
    }

    vendaScreen.style.display = 'flex';
    vendaScreen.classList.add('animacao-tela-venda');

    setTimeout(() => {
        vendaScreen.classList.remove('animacao-tela-venda');
        vendaScreen.style.display = 'none';
    }, 3000);
}


document.getElementById('form-venda').addEventListener('submit', (event) => {
    event.preventDefault();

    const valor = parseFloat(document.getElementById('valor').value);
    const vendedor = document.getElementById('vendedor').value;
    const pagamento = document.getElementById('pagamento').value;

    registrarVenda(vendedor, valor, pagamento);

    // Limpar campos
    document.getElementById('valor').value = '';
    document.getElementById('vendedor').value = '';
    document.getElementById('pagamento').value = '';
});

function salvarEstado() {
    localStorage.setItem('estadoMetas', JSON.stringify(state));
}

function carregarEstado() {
    const estadoSalvo = localStorage.getItem('estadoMetas');
    if (estadoSalvo) {
        Object.assign(state, JSON.parse(estadoSalvo));
    } else {
        calcularDiasRestantes();
    }
    atualizarMetas();
    atualizarVendasPorDepartamento();
    atualizarEquipeGanhando();
}

function calcularDiasRestantes() {
    const hoje = new Date();
    const ultimoDia = new Date(hoje.getFullYear(), hoje.getMonth() + 1, 0);
    state.diasRestantes = (ultimoDia - hoje) / (1000 * 60 * 60 * 24);
    state.diasRestantes = Math.ceil(state.diasRestantes);
}
document.addEventListener('DOMContentLoaded', () => {
    carregarEstado();
});

// Inicialização e atualização das metas
function atualizarMetas() {
    document.querySelector('.card-semanal h1').textContent = formatarValor(state.metaSemanal);
    document.querySelector('#valor-meta-mensal').textContent = formatarValor(state.metaMensal);
    document.querySelector('#meta-comercial1').textContent = formatarValor(state.metaComercial1);
    document.querySelector('#meta-comercial2').textContent = formatarValor(state.metaComercial2);
}