<?php

include "conexao.php";

date_default_timezone_set('America/Sao_Paulo');
// Iniciar a sessão, se não estiver iniciada
if (!isset($_SESSION)) {
    session_start();
}

// Recupera o ID do funcionário da sessão
$id_funcionario = $_SESSION['Id_Funcionario'];

// Pega a hora atual no formato Y-m-d H:i:s
$horario_atual = date("d-m H:i");

try {
    // Verifica todos os agendamentos atrasados para o consultor atual
    $sql = "SELECT cod_lead, DATE_FORMAT(data_agendamento, '%d-%m %H:%i') as 'data'
            FROM tbAgendamentos 
            WHERE cod_funcionario = :id_funcionario 
            AND DATE_FORMAT(data_agendamento, '%d-%m %H:%i') < :horario_atual 
            ORDER BY data_agendamento ASC"; // Ordena pelos agendamentos mais antigos
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_funcionario', $id_funcionario, PDO::PARAM_INT);
    $stmt->bindParam(':horario_atual', $horario_atual, PDO::PARAM_STR);
    $stmt->execute();

    $agendamentos_atrasados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($agendamentos_atrasados)) {
        // Se houver agendamentos atrasados, retorna como JSON
        // echo "<span style='color: white; position: absolute;'>" . json_encode(['atrasados' => $agendamentos_atrasados]) . "</span>";
        echo json_encode(['atrasados' => $agendamentos_atrasados]);
    } else {
        // Se não houver agendamentos atrasados, retorna null
        echo json_encode(['atrasados' => null]);
    }
} catch (PDOException $e) {
    // Captura e exibe o erro, se houver
    echo json_encode(['erro' => $e->getMessage()]);
} finally {
    // Fecha a conexão
    $conn = null;
}