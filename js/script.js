function confirmarExclusao() {
    let resposta = confirm("Deseja realmente excluir este lead?");
    if (resposta) {
        window.location.href = "../control/gerenciador.php?action=excluir";
    }
}

function controlaPaginacao(){
    const qtdeRegistros = document.getElementById("selectPaginacao").value;
    const url = new URL(window.location.href);

    if (qtdeRegistros !== '10') {
        url.searchParams.set('registros', qtdeRegistros);
    } else {
        url.searchParams.delete('registros');
    }

    window.location.href = url.href;
}

function filtrarLeads() {
    const filtroFase = document.getElementById("filtroFase").value;
    const filtroConsultor = document.getElementById("filtroConsultor").value;
    const filtroData = document.getElementById("filtroData").value;
    const filtroOrigem = document.getElementById("filtroOrigem").value;
    const filtroDataFinal = document.getElementById("filtroDataFinal").value;
    const filtroSituacao = document.getElementById("filtroSit").value;

    const url = new URL(window.location.href);

    if (filtroFase !== 'Todos') {
        url.searchParams.set('fase', filtroFase);
    } else {
        url.searchParams.delete('fase');
    }

    if (filtroConsultor !== '') {
        url.searchParams.set('consultor', filtroConsultor);
    } else {
        url.searchParams.delete('consultor');
    }

    if (filtroData !== '') {
        url.searchParams.set('data', filtroData);
    } else {
        url.searchParams.delete('data');
    }

    if (filtroData !== '' && filtroDataFinal !== '') {
        url.searchParams.set('data', filtroData);
        url.searchParams.set('dataFinal', filtroDataFinal);
    } else if (filtroDataFinal !== '') {
        url.searchParams.set('data', filtroDataFinal);
    } else {
        url.searchParams.delete('dataFinal');
    }
    if (filtroOrigem !== '') {
        url.searchParams.set('origem', filtroOrigem);
    } else {
        url.searchParams.delete('origem');
    }
    if (filtroSituacao !== '') {
        url.searchParams.set('situacao', filtroSituacao);
    } else {
        url.searchParams.delete('situacao');
    }

    window.location.href = url.href;
}


function formAgendamento() {
    let form = document.querySelector('.cadastrar-agendamento');

    if (!form.classList.contains('aberto')) {
        form.classList.add('aberto');
    } else{
        form.classList.remove('aberto');
    }
}

function formRetorno(){
    let form = document.getElementById("retornoForm");
    let pagina = document.getElementById("lead");

    if(form.style.display == "none"){
        form.style.display = "flex";
        pagina.style.filter = "blur(10px)"
    } else if (form.style.display !== "none") {
        form.style.display = "none";
        pagina.style.filter = "blur(0px)"
    }
}

function formVenda(){
    let form = document.getElementById("vendaForm");
    let pagina = document.getElementById("lead");

    if(form.style.display == "none"){
        form.style.display = "flex";
        pagina.style.filter = "blur(10px)"
    } else if (form.style.display !== "none") {
        form.style.display = "none";
        pagina.style.filter = "blur(0px)"
    }
}
function formPonto(){
    let form = document.getElementById("formPonto");
    let pagina = document.getElementById("lead");

    if(form.style.display == "none"){
        form.style.display = "flex";
        pagina.style.filter = "blur(10px)"
    } else if (form.style.display !== "none") {
        form.style.display = "none";
        pagina.style.filter = "blur(0px)"
    }
}
function formKeyword(){
    let form = document.getElementById("formKeyWord");
    let formPonto = document.getElementById("formPonto");

    if(form.style.display == "none"){
        form.style.display = "flex";
        formPonto.style.display = "none";
    } else if (form.style.display !== "none") {
        form.style.display = "none";
        formPonto.style.display = "flex";
    }
}

function formInvestimento(){
    let form = document.getElementById("investimentoForm");
    let pagina = document.getElementById("pagina-relatorios");

    if(form.style.display == "none"){
        form.style.display = "flex";
        pagina.style.filter = "blur(10px)"
    } else if (form.style.display !== "none") {
        form.style.display = "none";
        pagina.style.filter = "blur(0px)"
    }
}

function formMeta(){
    let form = document.getElementById("metaForm");
    let pagina = document.getElementById("pagina-relatorios");

    if(form.style.display == "none"){
        form.style.display = "flex";
        pagina.style.filter = "blur(10px)"
    } else if (form.style.display !== "none") {
        form.style.display = "none";
        pagina.style.filter = "blur(0px)"
    }
}