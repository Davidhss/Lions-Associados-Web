<?php
// Função para obter a quantidade total de leads cadastradas no dia atual
function getTotalLeadsDoDia()
{
    include "conexao.php";

    $hoje = date('Y-m-d');
    $sqlTotalLeads = "SELECT COUNT(*) as total_leads FROM tbLeads WHERE DATE(data_recebimento) = :hoje";
    $stmtTotalLeads = $conn->prepare($sqlTotalLeads);
    $stmtTotalLeads->bindParam(':hoje', $hoje);
    $stmtTotalLeads->execute();
    return $stmtTotalLeads->fetch(PDO::FETCH_ASSOC);
}

function getTotalLeadsDoMes()
{
    include "conexao.php";

    $mes = date('m');
    $sqlTotalLeads = "SELECT COUNT(*) as total_leads FROM tbLeads WHERE MONTH(data_recebimento) = :mes";
    $stmtTotalLeads = $conn->prepare($sqlTotalLeads);
    $stmtTotalLeads->bindParam(':mes', $mes);
    $stmtTotalLeads->execute();
    return $stmtTotalLeads->fetch(PDO::FETCH_ASSOC);
}

// Função para obter a quantidade de leads atribuídas no dia atual
function getTotalLeadsAtribuidasDoDia()
{
    include "conexao.php";

    $hoje = date('Y-m-d');
    $sqlLeadsAtribuidas = "SELECT COUNT(*) as total_leads_atribuidas FROM tbLeads WHERE cod_funcionario IS NOT NULL AND DATE(data_recebimento) = :hoje";
    $stmtLeadsAtribuidas = $conn->prepare($sqlLeadsAtribuidas);
    $stmtLeadsAtribuidas->bindParam(':hoje', $hoje);
    $stmtLeadsAtribuidas->execute();
    return $stmtLeadsAtribuidas->fetch(PDO::FETCH_ASSOC);
}

// Função para obter a quantidade de vendas realizadas no dia
function getTotalVendasDoDia()
{
    include "conexao.php";

    $hoje = date('Y-m-d');
    $sqlVendas = "SELECT COUNT(*) as total_vendas FROM tbRetornos WHERE cod_fase = (SELECT id_fase FROM tbFaseLead WHERE nome_fase = 'Venda') AND DATE(data_protocolo) = :hoje";
    $stmtVendas = $conn->prepare($sqlVendas);
    $stmtVendas->bindParam(':hoje', $hoje);
    $stmtVendas->execute();
    return $stmtVendas->fetch(PDO::FETCH_ASSOC);
}

function getTotalVendasDepartamento($departamento)
{
    include "conexao.php";

    $mes = date('m');
    $ano = date('Y');

    $sqlVendas = "SELECT COUNT(v.id) as total_vendas FROM tbVendas v
    INNER JOIN tbFuncionarios f ON v.cod_funcionario = f.id_funcionario
    WHERE f.cod_departamento = :dep AND MONTH(data_venda) = :mes AND YEAR(data_venda) = :ano;";
    $stmtVendas = $conn->prepare($sqlVendas);
    
    $stmtVendas->bindParam(':mes', $mes, PDO::PARAM_STR);
    $stmtVendas->bindParam(':ano', $ano, PDO::PARAM_STR);
    $stmtVendas->bindParam(':dep', $departamento, PDO::PARAM_INT);

    $stmtVendas->execute();
    $result = $stmtVendas->fetch(PDO::FETCH_ASSOC);

    return $result['total_vendas'] ?? 0;
}
function getTotalSomaVendasDepartamento($departamento)
{
    include "conexao.php";

    $mes = date('m');
    $ano = date('Y');

    $sqlVendas = "SELECT SUM(valor) as total_vendas FROM tbVendas
    INNER JOIN tbFuncionarios f ON cod_funcionario = f.id_funcionario
    WHERE f.cod_departamento = :dep AND MONTH(data_venda) = :mes AND YEAR(data_venda) = :ano;";
    $stmtVendas = $conn->prepare($sqlVendas);
    
    $stmtVendas->bindParam(':mes', $mes, PDO::PARAM_STR);
    $stmtVendas->bindParam(':ano', $ano, PDO::PARAM_STR);
    $stmtVendas->bindParam(':dep', $departamento, PDO::PARAM_INT);

    $stmtVendas->execute();
    $result = $stmtVendas->fetch(PDO::FETCH_ASSOC);

    return $result['total_vendas'] ?? 0;
}

function getTotalVendasIndividuaisMes($fun)
{
    include "conexao.php";

    $mes = date('m');
    $ano = date('Y');

    $sqlVendas = "SELECT COUNT(*) as total_vendas FROM tbVendas WHERE cod_funcionario = :fun AND MONTH(data_venda) = :mes AND YEAR(data_venda) = :ano;";
    $stmtVendas = $conn->prepare($sqlVendas);
    $stmtVendas->bindParam(':mes', $mes, PDO::PARAM_STR);
    $stmtVendas->bindParam(':ano', $ano, PDO::PARAM_STR);
    $stmtVendas->bindParam(':fun', $fun, PDO::PARAM_INT);
    $stmtVendas->execute();
    $result = $stmtVendas->fetch(PDO::FETCH_ASSOC);
    return $result['total_vendas'] ?? 0;
}

// Função para obter a quantidade de leads atribuídas a um consultor específico na data de hoje
function getQuantidadeLeadsAtribuidas($idFuncionario)
{
    include "conexao.php";

    $hoje = date('Y-m-d');
    $sql = "SELECT COUNT(id_Lead) as total_leads_atribuidas
            FROM tbLeads
            WHERE cod_funcionario = :idFuncionario
            AND DATE(data_recebimento) = :hoje";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':idFuncionario', $idFuncionario, PDO::PARAM_INT);
    $stmt->bindParam(':hoje', $hoje);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total_leads_atribuidas'];
}

// Função para obter a quantidade de negociações realizadas por um consultor específico na data de hoje
function getQuantidadeNegociacoes($idFuncionario)
{
    include "conexao.php";

    $hoje = date('Y-m-d');
    $sql = "SELECT COUNT(r.protocolo) as total_negociacoes
            FROM tbRetornos r
            INNER JOIN tbFaseLead fl ON r.cod_fase = fl.id_fase
            WHERE r.cod_funcionario = :idFuncionario
            AND fl.nome_fase = 'Venda'
            AND DATE(r.data_protocolo) = :hoje";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':idFuncionario', $idFuncionario, PDO::PARAM_INT);
    $stmt->bindParam(':hoje', $hoje);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total_negociacoes'];
}

// Função para obter a quantidade de novas leads para um consultor específico na data de hoje
function getQuantidadeNovasLeads($idFuncionario)
{
    include "conexao.php";

    $hoje = date('Y-m-d');
    $sql = "SELECT COUNT(l.id_Lead) as total_novas_leads
            FROM tbLeads l
            LEFT JOIN tbRetornos r ON l.id_Lead = r.cod_Lead
            WHERE l.cod_funcionario = :idFuncionario
            AND r.cod_Lead IS NULL
            AND DATE(l.data_recebimento) = :hoje";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':idFuncionario', $idFuncionario, PDO::PARAM_INT);
    $stmt->bindParam(':hoje', $hoje);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total_novas_leads'];
}

function getQuantiaLeads($filtroFase)
{
    include "conexao.php";
    try {
        $params = array();

        $where = "WHERE fl.nome_fase = :nome_fase";
        $params[':nome_fase'] = $filtroFase;

        $sql = "SELECT
                    l.id_Lead,
                    l.nome,
                    l.data_recebimento,
                    l.cod_funcionario,
                    o.nome_origem,
                    s.nome_situacao,
                    f.nome AS funcionario,
                    fl.nome_fase AS fase,
                    MAX(rt.data_protocolo) AS ultima_data_retorno
                FROM
                    tbLeads l
                INNER JOIN
                    tbProblemaLead p ON l.id_Lead = p.cod_lead
                INNER JOIN
                    tbSituacaoLead s ON p.cod_situacao = s.id_situacao
                INNER JOIN
                    tbOrigemLead o ON l.cod_origem = o.id_origem
                LEFT JOIN
                    tbFuncionarios f ON l.cod_funcionario = f.id_funcionario
                LEFT JOIN (
                    SELECT
                        cod_lead,
                        MAX(data_protocolo) AS max_data_protocolo
                    FROM
                        tbRetornos
                    GROUP BY
                        cod_lead
                ) rt_max ON l.id_Lead = rt_max.cod_lead
                LEFT JOIN
                    tbRetornos rt ON rt_max.cod_lead = rt.cod_lead AND rt_max.max_data_protocolo = rt.data_protocolo
                LEFT JOIN
                    tbFaseLead fl ON rt.cod_fase = fl.id_fase
                $where
                GROUP BY
                    l.id_Lead
                ORDER BY
                    ultima_data_retorno DESC, l.id_Lead DESC";

        // Preparar a consulta
        $stmt = $conn->prepare($sql);

        // Vincular parâmetros
        foreach ($params as $key => $value) {
            $stmt->bindParam($key, $params[$key]);
        }

        // Executar a consulta
        $stmt->execute();

        // Obter os resultados da consulta
        $leads = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Verificar se há leads
        if (empty($leads)) {
            return 0; // Retorna 0 se não houver leads encontradas
        }

        $quantidade = count($leads);
        // Retorna a quantidade de leads
        return $quantidade;
    } catch (PDOException $e) {
        // Registra o erro em um log
        error_log("Erro ao obter leads: " . $e->getMessage());

        // Lança uma exceção para ser capturada no código que chama esta função
        throw new Exception("Erro ao obter leads.");
    }
}


function getQuantiaFase($id_funcionario, $fase)
{
    include "conexao.php";

    $sql = "SELECT
            COUNT(*) AS total_leads
        FROM
            tbLeads l
        LEFT JOIN (
            SELECT
                cod_lead,
                MAX(data_protocolo) AS max_data_protocolo
            FROM
                tbRetornos
            GROUP BY
                cod_lead
        ) rt_max ON l.id_Lead = rt_max.cod_lead
        LEFT JOIN
            tbRetornos rt ON rt_max.cod_lead = rt.cod_lead AND rt_max.max_data_protocolo = rt.data_protocolo
        LEFT JOIN
            tbFaseLead fl ON rt.cod_fase = fl.id_fase
        WHERE
            l.cod_funcionario = :id_funcionario AND fl.nome_fase = :fase;";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_funcionario', $id_funcionario, PDO::PARAM_INT);
    $stmt->bindParam(':fase', $fase, PDO::PARAM_STR);
    $stmt->execute();

    // Obter os resultados da consulta
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if (empty($resultado)) {
        return array(); // Retorna um array vazio se não houver leads encontradas
    }

    return (int)$resultado['total_leads'];
}

function getQuantiaFasesTotaisMes($fase)
{
    include "conexao.php";

    $hoje = date('m');

    $sql = "SELECT
        l.id_Lead,
        fl.nome_fase AS fase,
        MAX(rt.data_protocolo) AS ultima_data_retorno
    FROM
        tbLeads l
    LEFT JOIN (
        SELECT
            cod_lead,
            MAX(data_protocolo) AS max_data_protocolo
        FROM
            tbRetornos
        GROUP BY
            cod_lead
    ) rt_max ON l.id_Lead = rt_max.cod_lead
    LEFT JOIN
        tbRetornos rt ON rt_max.cod_lead = rt.cod_lead AND rt_max.max_data_protocolo = rt.data_protocolo
    LEFT JOIN
        tbFaseLead fl ON rt.cod_fase = fl.id_fase
      WHERE fl.nome_fase = '$fase' AND MONTH(l.data_recebimento) = :hoje GROUP BY
        l.id_Lead
        ORDER BY
        ultima_data_retorno DESC, l.id_Lead DESC;";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':hoje', $hoje);
    $stmt->execute();


    // Obter os resultados da consulta
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($resultado)) {
        return array(); // Retorna um array vazio se não houver leads encontradas
    }

    return $resultado;
}

function verificarAgendamento($id_Lead)
{
    include "conexao.php";

    // Assumindo que o campo armazenando o horário do agendamento é 'hora_agendamento'
    $sql = "SELECT id, data_agendamento FROM tbAgendamentos WHERE cod_lead = :id_Lead ORDER BY id DESC LIMIT 1;";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_Lead', $id_Lead, PDO::PARAM_INT);  // Utilize prepared statements com parâmetros
    $stmt->execute();

    // Obter os resultados da consulta
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    // Retornar o horário do agendamento ou null caso não tenha resultado
    return ($resultado) ? $resultado['data_agendamento'] : null;
}

function getSomaValorBrutoMes()
{
    // **Conexão com o banco de dados**
    include "conexao.php";

    try {
        $mes = date('m');
        $ano = date('Y');

        // **Consulta SQL para somar as vendas no mês e ano especificados**
        $sql = "
            SELECT SUM(valor) AS total_vendas
            FROM tbVendas
            WHERE MONTH(data_venda) = :mes AND YEAR(data_venda) = :ano;
        ";

        // **Prepara a consulta**
        $stmt = $conn->prepare($sql);

        // **Vincula os parâmetros**
        $stmt->bindParam(":mes", $mes, PDO::PARAM_INT);
        $stmt->bindParam(":ano", $ano, PDO::PARAM_INT);

        // **Executa a consulta**
        $stmt->execute();

        // **Recupera o resultado**
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // **Retorna o total de vendas ou 0 caso não haja resultados**
        return $resultado['total_vendas'] ?? 0;
    } catch (PDOException $e) {
        // **Registra o erro no log**
        error_log("Erro ao calcular soma das vendas: " . $e->getMessage());

        // **Retorna 0 em caso de erro**
        return 0;
    } finally {
        // **Fecha a conexão com o banco de dados**
        $conn = null;
    }
}

function getSomaValorIndividualMes($fun)
{
    // **Conexão com o banco de dados**
    include "conexao.php";

    try {
        $mes = date('m');
        $ano = date('Y');

        // **Consulta SQL para somar as vendas no mês e ano especificados**
        $sql = "
            SELECT SUM(valor) AS total_vendas
            FROM tbVendas
            WHERE cod_funcionario = :fun AND MONTH(data_venda) = :mes AND YEAR(data_venda) = :ano;
        ";

        // **Prepara a consulta**
        $stmt = $conn->prepare($sql);

        // **Vincula os parâmetros**
        $stmt->bindParam(":fun", $fun, PDO::PARAM_INT);
        $stmt->bindParam(":mes", $mes, PDO::PARAM_INT);
        $stmt->bindParam(":ano", $ano, PDO::PARAM_INT);

        // **Executa a consulta**
        $stmt->execute();

        // **Recupera o resultado**
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // **Retorna o total de vendas ou 0 caso não haja resultados**
        return $resultado['total_vendas'] ?? 0;
    } catch (PDOException $e) {
        // **Registra o erro no log**
        error_log("Erro ao calcular soma das vendas: " . $e->getMessage());

        // **Retorna 0 em caso de erro**
        return 0;
    } finally {
        // **Fecha a conexão com o banco de dados**
        $conn = null;
    }
}

function getMetaDepartamento($departamento)
{
    // **Conexão com o banco de dados**
    include "conexao.php";

    try {
        $mes = date('m');
        $ano = date('Y');

        // **Consulta SQL para somar as vendas no mês e ano especificados**
        $sql = "
            SELECT 
                valor_meta
            FROM tbMetas
            WHERE cod_departamento = :dep AND MONTH(data_inicio) = :mes AND YEAR(data_inicio) = :ano;";

        // **Prepara a consulta**
        $stmt = $conn->prepare($sql);

        // **Vincula os parâmetros**
        $stmt->bindParam(":dep", $departamento, PDO::PARAM_INT);
        $stmt->bindParam(":ano", $ano, PDO::PARAM_INT);
        $stmt->bindParam(":mes", $mes, PDO::PARAM_INT);

        // **Executa a consulta**
        $stmt->execute();

        // **Recupera o resultado**
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // **Retorna o total de vendas ou 0 caso não haja resultados**
        return $resultado['valor_meta'] ?? 0;
    } catch (PDOException $e) {
        // **Registra o erro no log**
        error_log("Erro ao calcular soma das vendas: " . $e->getMessage());

        // **Retorna 0 em caso de erro**
        return 0;
    } finally {
        // **Fecha a conexão com o banco de dados**
        $conn = null;
    }
}

function contarLeadsPorOrigemMes($origem) {
    include 'conexao.php'; // Inclui a conexão com o banco

    try {
        $mes = date('m');
        $ano = date('Y');
        // Monta a query para contar os leads pela origem
        $sql = "
            SELECT COUNT(*) AS total_leads
            FROM tbLeads
            WHERE cod_origem = :origem
            AND MONTH(data_recebimento) = :mes
            AND YEAR(data_recebimento) = :ano
        ";

        // Prepara a consulta
        $stmt = $conn->prepare($sql);

        // Vincula o parâmetro
        $stmt->bindParam(':origem', $origem, PDO::PARAM_STR);
        $stmt->bindParam(':mes', $mes, PDO::PARAM_INT);
        $stmt->bindParam(':ano', $ano, PDO::PARAM_INT);
        // Executa a consulta
        $stmt->execute();

        // Recupera o resultado
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado['total_leads'] ?? 0; // Retorna 0 se não houver resultados
    } catch (PDOException $e) {
        echo "Erro ao contar leads: " . $e->getMessage();
        return 0;
    } finally {
        $conn = null; // Fecha a conexão
    }
}

function somaVendasPorOrigem($origem)
{
    include 'conexao.php'; // Inclui conexão com o banco

    try {
        $mes = date('m');
        $ano = date('Y');
        // Monta a query para calcular a soma das vendas
        $sql = "
            SELECT SUM(v.valor) AS total_vendas
            FROM tbVendas v
            INNER JOIN tbLeads l ON v.cod_lead = l.id_Lead
            WHERE l.cod_origem = :origem
            AND MONTH(v.data_venda) = :mes
            AND YEAR(v.data_venda) = :ano
        ";

        // Prepara a consulta
        $stmt = $conn->prepare($sql);

        // Vincula os parâmetros
        $stmt->bindParam(':origem', $origem, PDO::PARAM_STR);
        $stmt->bindParam(':mes', $mes, PDO::PARAM_INT);
        $stmt->bindParam(':ano', $ano, PDO::PARAM_INT);

        // Executa a consulta
        $stmt->execute();

        // Recupera o total das vendas
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado['total_vendas'] ?? 0; // Retorna 0 se não houver resultados
    } catch (PDOException $e) {
        echo "Erro ao calcular soma das vendas: " . $e->getMessage();
        return 0;
    } finally {
        $conn = null; // Fecha a conexão
    }
}

function getSomaValorLiquidoMes()
{
    // **Conexão com o banco de dados**
    include "conexao.php";

    try {
        $mes = date('m');
        $ano = date('Y');

        // **Consulta SQL para somar as vendas no mês e ano especificados**
        $sql = "
            SELECT SUM(valor_liquido) AS total_vendas
            FROM tbVendas
            WHERE MONTH(data_venda) = :mes AND YEAR(data_venda) = :ano;
        ";

        // **Prepara a consulta**
        $stmt = $conn->prepare($sql);

        // **Vincula os parâmetros**
        $stmt->bindParam(":mes", $mes, PDO::PARAM_INT);
        $stmt->bindParam(":ano", $ano, PDO::PARAM_INT);

        // **Executa a consulta**
        $stmt->execute();

        // **Recupera o resultado**
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // **Retorna o total de vendas ou 0 caso não haja resultados**
        return $resultado['total_vendas'] ?? 0;
    } catch (PDOException $e) {
        // **Registra o erro no log**
        error_log("Erro ao calcular soma das vendas: " . $e->getMessage());

        // **Retorna 0 em caso de erro**
        return 0;
    } finally {
        // **Fecha a conexão com o banco de dados**
        $conn = null;
    }
}
function getValorInvestimento()
{
    // **Conexão com o banco de dados**
    include "conexao.php";

    try {
        // **Consulta SQL para somar as vendas no mês e ano especificados**
        $sql = "
            SELECT valor
            FROM tbInvestimento
            WHERE id = 1;
        ";

        // **Prepara a consulta**
        $stmt = $conn->prepare($sql);

        // **Executa a consulta**
        $stmt->execute();

        // **Recupera o resultado**
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // **Retorna o total de vendas ou 0 caso não haja resultados**
        return $resultado['valor'] ?? 0;
    } catch (PDOException $e) {
        // **Registra o erro no log**
        error_log("Erro ao calcular soma das vendas: " . $e->getMessage());

        // **Retorna 0 em caso de erro**
        return 0;
    } finally {
        // **Fecha a conexão com o banco de dados**
        $conn = null;
    }
}

function calcularDiasUteis($dataInicio, $dataFim, $feriados = []) {
    $diasUteis = 0;
    $dataAtual = strtotime($dataInicio);
    $dataFim = strtotime($dataFim);

    while ($dataAtual <= $dataFim) {
        $diaSemana = date("N", $dataAtual); // 1 (segunda-feira) a 7 (domingo)
        $dataFormatada = date("Y-m-d", $dataAtual);

        if ($diaSemana < 6 && !in_array($dataFormatada, $feriados)) { // Dias úteis: segunda a sexta
            $diasUteis++;
        }

        $dataAtual = strtotime("+1 day", $dataAtual);
    }

    return $diasUteis;
}

function calcularMediaDiaria($vendasTotais, $dataInicio, $feriados = []) {
    $diasUteis = calcularDiasUteis($dataInicio, date('Y-m-d'), $feriados);
    if ($diasUteis === 0) {
        return 0; // Evitar divisão por zero
    }
    return $vendasTotais / $diasUteis;
}