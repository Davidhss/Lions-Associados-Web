<?php 

// Cadastrar lead através do formulário
function inserirLead()
{
  include "conexao.php";  // Assume que o arquivo conexao.php contém a conexão PDO

  try {
    // Iniciar transação para garantir a integridade dos dados
    $conn->beginTransaction();

    // **Obter dados do formulário**
    $nome = $_POST['nomeLead'];
    $email = $_POST['emailLead'];
    $celular = $_POST['celLead'];
    $origem = $_POST['tipoPag'];
    $_SESSION['tipoPag'] = $_POST['tipoPag'];

    // Preparar consulta para inserir lead (prepared statement)
    $sql = "INSERT INTO tbLeads (nome, email, celular, cod_funcionario, cod_origem, cod_horario) VALUES (:nome, :email, :celular, NULL, :origem, NULL)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->bindParam(":celular", $celular, PDO::PARAM_STR);
    $stmt->bindParam(":origem", $origem, PDO::PARAM_INT);
    $stmt->execute();

    // Obter o ID do lead inserido
    $idLead = $conn->lastInsertId();

    // Se a inserção for bem-sucedida, buscar o lead pelo celular
    if ($idLead > 0) {
      $sql_query = "SELECT * FROM tbLeads WHERE celular = :celular";
      $stmt = $conn->prepare($sql_query);
      $stmt->bindParam(":celular", $celular, PDO::PARAM_STR);
      $stmt->execute();

      $lead = $stmt->fetch(PDO::FETCH_ASSOC);

      // Iniciar sessão e armazenar o ID do lead
      if (!isset($_SESSION)) {
        session_start();
      }

      $_SESSION['id_Lead'] = $lead['id_Lead'];

      // Commitar a transação e redirecionar para o formulário de situação
      $conn->commit();
      header("Location: ../formulario_sit.html");
    } else {
      throw new PDOException("Erro ao inserir lead: ID não gerado");
    }
  } catch (PDOException $e) {
    // Desfazer as alterações em caso de erro (rollback)
    $conn->rollBack();
    echo "Erro ao inserir lead: " . $e->getMessage();
  } finally {
    // Fechar a conexão com o banco (mesmo em caso de exceções)
    $conn = null;
  }
};

// (Segunda parte do formulário) Atualiza as informações do Lead 
function alterarSituacaoLead()
{
  include "conexao.php";  // Assume que o arquivo conexao.php contém a conexão PDO

  try {
    // Iniciar transação para garantir a integridade dos dados
    $conn->beginTransaction();

    // **Obter dados do formulário**
    $situacao = $_POST['sitLead'];
    $descricao = $_POST['descLead'];
    $lead = $_SESSION['id_Lead'];

    // Preparar consulta para inserir problema do lead (prepared statement)
    $sql = "INSERT INTO tbProblemaLead (desc_problema, cod_situacao, cod_lead) VALUES (:descricao, :situacao, :lead)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":descricao", $descricao, PDO::PARAM_STR);
    $stmt->bindParam(":situacao", $situacao, PDO::PARAM_INT);
    $stmt->bindParam(":lead", $lead, PDO::PARAM_INT);
    $stmt->execute();

    // Obter o tipo de página
    $tipoPagina = $_POST['tipoPag'];

    // Redirecionar para a página correta de acordo com o tipo
    if ($tipoPagina == "Ebook") {
      header("Location: ../agradecimentos.php");
    } else {
      header("Location: ../formulario_final.html");
    }

    // Commitar a transação
    $conn->commit();
  } catch (PDOException $e) {
    // Desfazer as alterações em caso de erro (rollback)
    $conn->rollBack();
    echo "Erro ao inserir problema do lead: " . $e->getMessage();
  } finally {
    // Fechar a conexão com o banco (mesmo em caso de exceções)
    $conn = null;
  }
}

// (Terceira parte do formulário) Atualiza as informações do Lead 
function alterarHorarioLead()
{
  include "conexao.php";  // Assume que o arquivo conexao.php contém a conexão PDO

  try {
    // Iniciar transação para garantir a integridade dos dados
    $conn->beginTransaction();

    // **Obter dados do formulário**
    $melhorHorario = $_POST['horaLead'];
    $lead = $_SESSION['id_Lead'];

    // Preparar consulta para atualizar horário do lead (prepared statement)
    $sql = "UPDATE tbLeads SET cod_horario = :melhorHorario WHERE id_Lead = :lead";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":melhorHorario", $melhorHorario, PDO::PARAM_INT);
    $stmt->bindParam(":lead", $lead, PDO::PARAM_INT);
    $stmt->execute();

    // Redirecionar para a página de agradecimentos
    header("Location: ../agradecimentos.php");

    // Commitar a transação
    $conn->commit();
  } catch (PDOException $e) {
    // Desfazer as alterações em caso de erro (rollback)
    $conn->rollBack();
    echo "Erro ao atualizar horário do lead: " . $e->getMessage();
  } finally {
    // Fechar a conexão com o banco (mesmo em caso de exceções)
    $conn = null;
  }
}