<?php

// Inicia a sessão se ela não tiver sido iniciada
if (!isset($_SESSION)) {
  session_start();
}

// -------------------------- SEGURANÇA --------------------------

//Proteção caso tentem entrar na plataforma sem verificar as credenciais do login
function protecaoPlataforma()
{
  if (!isset($_SESSION)) {
    session_start();
  }

  if (!isset($_SESSION['Id_Funcionario'])) {
    header("Location: ../index.php");
  }
}


// -------------------------- VERIFICAÇÕES --------------------------

function procuraAgendamentosLead($id_Lead)
{
  include "conexao.php";

  // Verifica todos os agendamentos atrasados para o consultor atual
  $sql = "SELECT * FROM tbAgendamentos 
  WHERE cod_lead = :id_lead";

  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id_lead', $id_Lead, PDO::PARAM_INT);
  $stmt->execute();

  $agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (!empty($agendamentos)) {
    return false;
  } else {
    return true;
  }
}

//Verificação de dados repetidos através do email
function verificaEmailRepetido()
{
  include "conexao.php";  // Assume que o arquivo conexao.php contém a conexão PDO

  $email = $POST['emailLead'];

  try {
    // Preparar consulta para verificar email (prepared statement)
    $sql = "SELECT COUNT(*) AS quantidade FROM tbLeads WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->execute();

    // Obter a quantidade de registros encontrados
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    $quantidade = $resultado['quantidade'];

    // Retornar true se email já existir, false caso contrário
    return $quantidade > 0;
  } catch (PDOException $e) {
    echo "Erro ao verificar email: " . $e->getMessage();
    return false;
  } finally {
    // Fecha a conexão com o banco (mesmo em caso de exceções)
    $conn = null;
  }
};

//Verificação de dados repetidos através do celular
function verificarCelularRepetido()
{
  include "conexao.php";  // Assume que o arquivo conexao.php contém a conexão PDO

  $celular = $_POST['celLeadNova'];

  try {
    // Preparar consulta para verificar celular (prepared statement)
    $sql = "SELECT COUNT(*) AS quantidade FROM tbLeads WHERE celular = :celular";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":celular", $celular, PDO::PARAM_STR);
    $stmt->execute();

    // Obter a quantidade de registros encontrados
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    $quantidade = $resultado['quantidade'];

    // Retornar true se celular já existir, false caso contrário
    return $quantidade > 0;
  } catch (PDOException $e) {
    echo "Erro ao verificar celular: " . $e->getMessage();
    return false;
  } finally {
    // Fecha a conexão com o banco (mesmo em caso de exceções)
    $conn = null;
  }
};

// Função para verificar se o telefone já existe no banco de dados
function phone_exists($conn, $phone)
{
  $stmt = $conn->prepare("SELECT 1 FROM tbLeads WHERE celular = ?");
  $stmt->execute([$phone]);
  return $stmt->fetchColumn() > 0;
}


//Verifica se o usuário existe no banco de dados, se existir permite entrar na plataforma Lions
function verificarLogin()
{
  // **Conexão com o banco de dados**
  include "conexao.php";

  // **Obtenção do login e senha digitados pelo usuário**
  $login = $_POST['login'];
  $senha = $_POST['senha'];

  try {
    // **Prepara consulta para verificar login e senha (prepared statement)**
    $sql = "SELECT * FROM tbFuncionarios WHERE login = :login AND senha = :senha";
    $stmt = $conn->prepare($sql);

    // **Vincula os parâmetros aos valores**
    $stmt->bindParam(":login", $login, PDO::PARAM_STR);
    $stmt->bindParam(":senha", $senha, PDO::PARAM_STR);

    // **Executa a consulta**
    $stmt->execute();

    // **Obtém o resultado da consulta**
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // **Verifica se o login e senha foram encontrados**
    if ($result) {
      // **Se a sessão não estiver iniciada, inicia-a**
      if (!isset($_SESSION)) {
        session_start();
      }

      // **Armazena os dados do funcionário na sessão**
      $_SESSION['Id_Funcionario'] = $result['id_funcionario'];
      $_SESSION['Nome'] = $result['nome'];
      $_SESSION['Cargo'] = $result['cod_cargo'];
      $_SESSION['Caminho_Imagem'] = $result['path_imgFun'];

      // **Redireciona para a plataforma Lions**

      header("Location: ./plataforma/inicio.php");
    } else {
      // **Exibe uma mensagem de erro de login inválido e redireciona para a página de login**
      echo "<div class='popup'>
              <div class='mensagem'>
                Login e/ou Senha inválidos.
              </div>
            </div>";
    }

    // **Fecha o statement (using PDO method)**
    $stmt = null;
  } catch (PDOException $e) {
    // **Registra o erro em um log**
    error_log("Erro ao verificar login: " . $e->getMessage());

    // **Exibe uma mensagem de erro genérica e redireciona para a página de login**
    echo "<div class='popup'>
            <div class='mensagem'>
              Erro ao verificar login. Tente novamente mais tarde.
            </div>
          </div>";
    header("Location: ./index.php");
  }
}


// -------------------------- AJUSTES NO TXT --------------------------

// Converte o número de celular de acordo com as regras
function formatarNumeroCelular($phone)
{
  $phone = preg_replace('/\D/', '', $phone);
  if (strlen($phone) == 11) {
    $formatted_phone = sprintf(
      '(%s) %s-%s',
      substr($phone, 0, 2),
      substr($phone, 2, 5),
      substr($phone, 7)
    );
    return $formatted_phone;
  } else {
    return $phone;
  }
}

// Função para limpar dados de entrada
function clean_input($data)
{
  return htmlspecialchars(stripslashes(trim($data)));
}


// -------------------------- OPERAÇÕES CRUD --------------------------

// Realiza o cadastro de uma nova Lead
function cadastrarLead()
{
  // **Conexão com o banco de dados**
  include "conexao.php";

  // **Obtenção dos dados do formulário**
  $nome = $_POST['nomeLeadNova'];
  $email = $_POST['emailLeadNova'];
  $celular = $_POST['celLeadNova'];
  $origem = $_POST['tipoPagNova'];
  $horario = $_POST['horaLeadNova'];
  $situacao = $_POST['sitLeadNova'];
  $descricao = $_POST['descLeadNova'];
  $funcionario = $_POST['selector'];

  if ($funcionario == 0) {
    $funcionario = NULL;
  }

  try {
    // **Inicia transação para garantir a integridade dos dados**
    $conn->beginTransaction();

    // **Prepara consulta para inserir lead (prepared statement)**
    $sql = "
      INSERT INTO tbLeads (nome, email, celular, cod_funcionario, cod_origem, cod_horario)
      VALUES (:nome, :email, :celular, :funcionario, :origem, :horario);
    ";
    $stmt = $conn->prepare($sql);

    // **Vincula os parâmetros aos valores**
    $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->bindParam(":celular", $celular, PDO::PARAM_STR);
    $stmt->bindParam(":funcionario", $funcionario, PDO::PARAM_INT);
    $stmt->bindParam(":origem", $origem, PDO::PARAM_INT);
    $stmt->bindParam(":horario", $horario, PDO::PARAM_INT);

    // **Executa a consulta**
    $stmt->execute();

    // **Obtém o ID do lead recém-inserido**
    $idLead = $conn->lastInsertId();

    // **Prepara consulta para inserir problema do lead (prepared statement)**
    $sql = "
      INSERT INTO tbProblemaLead (desc_problema, cod_situacao, cod_lead)
      VALUES (:descricao, :situacao, :idLead);
    ";
    $stmt = $conn->prepare($sql);

    // **Vincula os parâmetros aos valores**
    $stmt->bindParam(":descricao", $descricao, PDO::PARAM_STR);
    $stmt->bindParam(":situacao", $situacao, PDO::PARAM_INT);
    $stmt->bindParam(":idLead", $idLead, PDO::PARAM_INT);

    // **Executa a consulta**
    $stmt->execute();

    // **Commita a transação**
    $conn->commit();

    // **Fecha a conexão com o banco de dados**
    $conn = null;

    // **Retorna true para indicar sucesso**
    return true;
  } catch (PDOException $e) {
    // Desfaz as alterações em caso de erro (rollback)
    if ($conn) { // Check if connection is not null before rollback
      $conn->rollBack();
    }

    // **Registra o erro em um log**
    error_log("Erro ao inserir lead: " . $e->getMessage());

    // **Retorna false para indicar falha**
    return false;
  }
}

// Faz o cadastro de um agendamento para o lead
function cadastrarAgendamento()
{
  // **Conexão com o banco de dados**
  include "conexao.php";

  try {
    $cod = $_POST['txtId'];
    $data = $_POST['txtDataAgenda'];
    $descricao = $_POST['txtDescAgenda'];
    $funcionario = $_POST['txtConsultor'];
    $tipo = $_POST['txtTipoPag'];

    // **Inicia transação para garantir a integridade dos dados**
    $conn->beginTransaction();

    // **Prepara consulta para inserir lead (prepared statement)**
    $sql = "
      INSERT INTO tbAgendamentos (cod_lead, cod_funcionario, descricao, data_agendamento, status)
      VALUES (:cod_lead, :cod_funcionario, :descricao, :data_agendamento, 0);
    ";
    $stmt = $conn->prepare($sql);

    // **Vincula os parâmetros aos valores**
    if ($tipo == "lead") {
      $sql_verifica = "SELECT * FROM tbAgendamentos WHERE cod_lead = $cod";
      $stmt_verifica = $conn->prepare($sql_verifica);
      $stmt_verifica->execute();
      // Obter os resultados da consulta
      $resultados = $stmt_verifica->fetchAll(PDO::FETCH_ASSOC);

      if (!empty($resultados)) {
        // Se houver um ou mais agendamentos
        $sql_del = "DELETE FROM tbAgendamentos WHERE cod_lead = $cod";
        $stmt_del = $conn->prepare($sql_del);

        if ($stmt_del->execute()) {
          $stmt->bindParam(":cod_lead", $cod, PDO::PARAM_INT);
        } else {
          echo "Erro ao deletar outros agendamentos";
        }
      } else {
        // Se não houver agendamentos
        $stmt->bindParam(":cod_lead", $cod, PDO::PARAM_INT);
      }
    } else if ($tipo == "oportunidade") {
      $stmt->bindParam(":cod_lead", NULL, PDO::PARAM_STR);
      $stmt->bindParam(":cod_oportunidade", $cod, PDO::PARAM_STR);
    }

    $stmt->bindParam(":cod_funcionario", $funcionario, PDO::PARAM_INT);
    $stmt->bindParam(":descricao", $descricao, PDO::PARAM_STR);
    $stmt->bindParam(":data_agendamento", $data, PDO::PARAM_STR);

    // **Executa a consulta**
    $stmt->execute();

    // **Commita a transação**
    $conn->commit();

    // **Fecha a conexão com o banco de dados**
    $conn = null;

    // **Retorna true para indicar sucesso**
    return true;
  } catch (PDOException $e) {
    // Desfaz as alterações em caso de erro (rollback)
    if ($conn) { // Check if connection is not null before rollback
      $conn->rollBack();
    }

    // **Registra o erro em um log**
    error_log("Erro ao cadastrar agendamento: " . $e->getMessage());

    // **Retorna false para indicar falha**
    return false;
  }
}

// Realiza o cadastro e uma nova Oportunidade
function cadastrarOportunidade()
{
  // **Conexão com o banco de dados**
  include "conexao.php";

  try {
    $cod_lead = $_POST['txtIdLead'];
    $nome = $_POST['txtNomeOportunidade'];
    $valor = $_POST['txtValorOportunidade'];
    $fase = $_POST['txtEtapaOportunidade'];
    $email = $_POST['EmailOportunidade'];
    $celular = $_POST['CelularOportunidade'];
    $origem = $_POST['OrigemOportunidade'];
    $funcionario = $_SESSION['Id_Funcionario'];

    // **Inicia transação para garantir a integridade dos dados**
    $conn->beginTransaction();

    // **Prepara consulta para inserir lead (prepared statement)**
    $sql = "
      INSERT INTO tbOportunidades (nome, email, valor, celular, cod_lead, cod_funcionario, cod_origem, cod_fase)
      VALUES (:nome, :email, :valor, :celular, :lead, :funcionario, :origem, :fase);
    ";
    $stmt = $conn->prepare($sql);

    // **Vincula os parâmetros aos valores**
    $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);
    $stmt->bindParam(":celular", $celular, PDO::PARAM_STR);
    $stmt->bindParam(":lead", $cod_lead, PDO::PARAM_INT);
    $stmt->bindParam(":funcionario", $funcionario, PDO::PARAM_INT);
    $stmt->bindParam(":origem", $origem, PDO::PARAM_INT);
    $stmt->bindParam(":fase", $fase, PDO::PARAM_INT);

    // **Executa a consulta**
    $stmt->execute();

    // **Commita a transação**
    $conn->commit();

    // **Fecha a conexão com o banco de dados**
    $conn = null;

    // **Retorna true para indicar sucesso**
    return true;
  } catch (PDOException $e) {
    // Desfaz as alterações em caso de erro (rollback)
    if ($conn) { // Check if connection is not null before rollback
      $conn->rollBack();
    }

    // **Registra o erro em um log**
    error_log("Erro ao inserir lead: " . $e->getMessage());

    // **Retorna false para indicar falha**
    return false;
  }
}
function getServicos()
{
  include "conexao.php";

  $sql = "SELECT id, nome FROM tbServicos;";

  $stm = $conn->prepare($sql);
  $stm->execute();

  $resultado = $stm->fetchAll(PDO::FETCH_ASSOC);

  return $resultado;
}

//Adicionar um retorno para a lead
function cadastrarRetorno(int $id_Lead, $andamento, $observacao)
{
  // **Conexão com o banco de dados**
  include "conexao.php";

  // **Inicia a sessão se não estiver iniciada**
  if (!isset($_SESSION)) {
    session_start();
  }

  // **Recupera o ID do funcionário da sessão**
  $id_funcionario = $_SESSION['Id_Funcionario'];

  try {
    // **Prepara consulta para inserir retorno (prepared statement)**
    $sql = "INSERT INTO tbRetornos (observacao, cod_fase, cod_Lead, cod_funcionario) VALUES (:observacao, :andamento, :id_Lead, :id_funcionario);";
    $stmt = $conn->prepare($sql);

    // **Vincula os parâmetros aos valores**
    $stmt->bindParam(":observacao", $observacao, PDO::PARAM_STR);
    $stmt->bindParam(":andamento", $andamento, PDO::PARAM_INT);
    $stmt->bindParam(":id_Lead", $id_Lead, PDO::PARAM_INT);
    $stmt->bindParam(":id_funcionario", $id_funcionario, PDO::PARAM_INT);

    // **Executa a consulta**
    $stmt->execute();

    // **Atualiza a data de modificação no lead**
    $sql2 = "UPDATE tbLeads SET data_modificacao = NOW() WHERE id_Lead = :id_Lead";
    $executar = $conn->prepare($sql2);
    $executar->bindParam(":id_Lead", $id_Lead, PDO::PARAM_INT);
    $executar->execute();

    // **Deleta os agendamentos para o lead**
    $sql_del = "DELETE FROM tbAgendamentos WHERE cod_lead = :id_Lead";
    $stmt_del = $conn->prepare($sql_del);
    $stmt_del->bindParam(":id_Lead", $id_Lead, PDO::PARAM_INT);

    // **Executa a consulta de deleção**
    if ($stmt_del->execute()) {
      // **Redireciona para a página de detalhes do lead**
      header("Location: ../plataforma/pagDetalhesLead.php?id=$id_Lead");
    } else {
      echo "Erro ao deletar os agendamentos.";
    }
  } catch (PDOException $e) {
    // **Registra o erro em um log**
    error_log("Erro ao inserir retorno: " . $e->getMessage());

    // **Exibe uma mensagem de erro genérica**
    echo "Erro ao inserir retorno: " . $e->getMessage();
  } finally {
    // **Fecha a conexão com o banco de dados**
    $conn = null;
  }
}

function cadastrarVenda(int $idLead = NULL, $idfunc, $valor, $valor_liquido, $data_venda, int $servico, $descricao, int $pagamento)
{
  // **Conexão com o banco de dados**
  include "conexao.php";

  // **Inicia a sessão se não estiver iniciada**
  if (!isset($_SESSION)) {
    session_start();
  }

  try {
    // **Prepara consulta para inserir retorno (prepared statement)**
    $sql = "INSERT INTO tbVendas (cod_lead, cod_funcionario, valor, valor_liquido, data_venda, cod_servico, descricao, cod_pagamento) VALUES (:lead, :funcionario, :valor, :valor_liquido, :datavenda, :servico, :descricao, :pagamento);";
    $stmt = $conn->prepare($sql);

    // **Vincula os parâmetros aos valores**

    $stmt->bindParam(":lead", $idLead, PDO::PARAM_INT);
    $stmt->bindParam(":funcionario", $idfunc, PDO::PARAM_INT);
    $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);
    $stmt->bindParam(":valor_liquido", $valor_liquido, PDO::PARAM_STR);
    $stmt->bindParam(":datavenda", $data_venda, PDO::PARAM_STR);
    $stmt->bindParam(":servico", $servico, PDO::PARAM_INT);
    $stmt->bindParam(":descricao", $descricao, PDO::PARAM_STR);
    $stmt->bindParam(":pagamento", $pagamento, PDO::PARAM_INT);

    // **Executa a consulta**
    $stmt->execute();

    if ($idLead !== null) {
      cadastrarRetorno($idLead, 7, $descricao);

      // **Redireciona para a página de detalhes do lead**
      header("Location: ../plataforma/pagDetalhesLead.php?id=$idLead");
    } else {
      header("Location: ../plataforma/inicio.php");
    }
  } catch (PDOException $e) {
    // **Registra o erro em um log**
    error_log("Erro ao inserir retorno: " . $e->getMessage());

    // **Exibe uma mensagem de erro genérica**
    echo "Erro ao inserir registro.";
  } finally {
    // **Fecha a conexão com o banco de dados**
    $conn = null;
  }
};


function cadastrarMeta(int $departamento, $valor, $data_inicio, $data_fim, int $status)
{
  // **Conexão com o banco de dados**
  include "conexao.php";

  // **Inicia a sessão se não estiver iniciada**
  if (!isset($_SESSION)) {
    session_start();
  }

  try {
    $sql = "SELECT * FROM tbMetas WHERE cod_departamento = :dep";
    $stmt = $conn->prepare($sql);

    // **Vincula os parâmetros aos valores**
    $stmt->bindParam(":dep", $departamento, PDO::PARAM_INT);

    // **Executa a consulta**
    $stmt->execute();

    // **Obtém o resultado da consulta**
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // **Verifica se o login e senha foram encontrados**
    if (!$result) {
      // **Prepara consulta para inserir retorno (prepared statement)**
      $sql = "INSERT INTO tbMetas (cod_departamento, valor_meta, data_inicio, data_fim, status) VALUES (:dep, :valor, :dataini, :datafim, :status);";
      $stmt = $conn->prepare($sql);

      // **Vincula os parâmetros aos valores**

      $stmt->bindParam(":dep", $departamento, PDO::PARAM_INT);
      $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);
      $stmt->bindParam(":dataini", $data_inicio, PDO::PARAM_STR);
      $stmt->bindParam(":datafim", $data_fim, PDO::PARAM_STR);
      $stmt->bindParam(":status", $status, PDO::PARAM_INT);

      // **Executa a consulta**
      $stmt->execute();

      return true;
    } else {
      // **Prepara consulta para inserir retorno (prepared statement)**
      $sql = "UPDATE tbMetas SET valor_meta = :valor, data_inicio = :dataini, data_fim = :datafim, status = :status WHERE cod_departamento = :dep;";
      $stmt = $conn->prepare($sql);

      // **Vincula os parâmetros aos valores**

      $stmt->bindParam(":dep", $departamento, PDO::PARAM_INT);
      $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);
      $stmt->bindParam(":dataini", $data_inicio, PDO::PARAM_STR);
      $stmt->bindParam(":datafim", $data_fim, PDO::PARAM_STR);
      $stmt->bindParam(":status", $status, PDO::PARAM_INT);

      // **Executa a consulta**
      $stmt->execute();

      return true;
    }
  } catch (PDOException $e) {
    // **Registra o erro em um log**
    error_log("Erro ao inserir retorno: " . $e->getMessage());

    // **Exibe uma mensagem de erro genérica**
    echo "Erro ao inserir registro.";
  } finally {
    // **Fecha a conexão com o banco de dados**
    $conn = null;
  }
};

function inserirLeadsEmMassa()
{
  // **Conexão com o banco de dados**
  include "conexao.php";

  // **Obtenção dos dados do formulário**
  $names = explode("\n", $_POST['txtNomes']);
  $emails = explode("\n", $_POST['txtEmails']);
  $phones = explode("\n", $_POST['txtCelulares']);
  $origins = explode("\n", $_POST['txtOrigens']);
  $descriptions = explode("\n", $_POST['txtDescricoes']);

  $total_leads = count($names);
  $success_count = 0;
  $error_count = 0;

  // **Prepara consulta para inserir problema do lead (prepared statement)**
  for ($i = 0; $i < $total_leads; $i++) {
    $name = clean_input($names[$i]);
    $email = clean_input($emails[$i]);
    $phone = formatarNumeroCelular(clean_input($phones[$i]));
    $origin = clean_input($origins[$i]);
    $description = clean_input($descriptions[$i]);

    if (strtolower($origin) === 'fb') {
      $origin = 15;
    } elseif (strtolower($origin) === 'ig') {
      $origin = 16;
    } else {
      $error_count++;
      continue; // pula para a próxima iteração se a origem não for válida
    }

    if (!empty($name) || !empty($email) || !empty($phone) || !empty($origin) || !empty($description)) {
      if (!phone_exists($conn, $phone)) {


        $sql = "INSERT INTO tbLeads (nome, email, celular, cod_funcionario, cod_origem, cod_horario) VALUES (:nome , :email, :celular, NULL, :origem, 4)";

        $stmt = $conn->prepare($sql);

        // **Vincula os parâmetros aos valores**
        $stmt->bindParam(":nome", $name, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":celular", $phone, PDO::PARAM_STR);
        $stmt->bindParam(":origem", $origin, PDO::PARAM_INT);

        // **Executa a consulta**
        if ($stmt->execute() === TRUE) {
          // **Obtém o ID do lead recém-inserido**
          $idLead = $conn->lastInsertId();

          $sql = "INSERT INTO tbProblemaLead (desc_problema, cod_situacao, cod_lead) VALUES (:descricao, 11, :idLead);";

          $stmt = $conn->prepare($sql);

          // **Vincula os parâmetros aos valores**
          $stmt->bindParam(":descricao", $description, PDO::PARAM_STR);
          $stmt->bindParam(":idLead", $idLead, PDO::PARAM_INT);

          // **Executa a consulta**
          $stmt->execute();

          $success_count++;
        } else {
          $error_count++;
        }
      } else {
        $error_count++;
      }
    } else {
      $error_count++;
    }
  }

  $conn = null;

  echo "<div class='resultado'>Leads cadastradas com sucesso: <span class='sucessos'>" . $success_count . "</span></div>";
  echo "<div class='resultado'>Erros ao cadastrar leads: <span class='erros'>" . $error_count . "</span></div>";

  // **Retorna true para indicar sucesso**
  return true;
}

function atribuirLead(int $lead, int $funcionarioAtribuido)
{
  // **Conexão com o banco de dados**
  include "conexao.php";

  try {
    // **Prepara consulta para atualizar lead (prepared statement)**
    if ($funcionarioAtribuido === 0) {
      // Desassocia o lead de qualquer funcionário
      $sql = "UPDATE tbLeads SET cod_funcionario = NULL WHERE id_Lead = :lead;";
    } else {
      // Atribui o lead ao funcionário especificado
      $sql = "UPDATE tbLeads SET cod_funcionario = :funcionarioAtribuido WHERE id_Lead = :lead;";
    }
    $stmt = $conn->prepare($sql);

    // **Vincula os parâmetros aos valores**
    $stmt->bindParam(":lead", $lead, PDO::PARAM_INT);
    $stmt->bindParam(":funcionarioAtribuido", $funcionarioAtribuido, PDO::PARAM_INT);

    // **Executa a consulta**
    $stmt->execute();

    // **Atualiza a data de modificação no lead**
    $sql2 = "UPDATE tbLeads SET data_modificacao = NOW() WHERE id_Lead = :id_Lead";
    $executar = $conn->prepare($sql2);
    $executar->bindParam(":id_Lead", $lead, PDO::PARAM_INT);
    $executar->execute();

    $sql_notificacao = "INSERT INTO tbNotificacao (mensagem, cod_funcionario, status) VALUES ('Nova lead atribuída', :funcionario, 0)";

    $stm = $conn->prepare($sql_notificacao);
    $stm->bindParam(":funcionario", $funcionarioAtribuido, PDO::PARAM_INT);

    $stm->execute();

    // **Redireciona para a página anterior da atribuição**
    echo "<script>javascript:history.go(-2)</script>";
  } catch (PDOException $e) {
    // **Registra o erro em um log**
    error_log("Erro ao atualizar lead: " . $e->getMessage());

    // **Exibe uma mensagem de erro genérica**
    echo "Erro ao atualizar registro.";
  } finally {
    // **Fecha a conexão com o banco de dados**
    $conn = null;
  }
}

//Excluir Lead
function excluirLead(int $idLead)
{
  include "conexao.php";  // Assume que o arquivo conexao.php contém a conexão PDO

  try {
    // Iniciar transação para garantir a integridade dos dados
    $conn->beginTransaction();

    // Deletar retornos relacionados ao lead (prepared statement)
    $sql_delete_retornos = "DELETE FROM tbRetornos WHERE cod_Lead = :idLead";
    $stmt = $conn->prepare($sql_delete_retornos);
    $stmt->bindParam(":idLead", $idLead, PDO::PARAM_INT);
    $stmt->execute();

    // Deletar problemas relacionados ao lead (prepared statement)
    $sql_delete_problema = "DELETE FROM tbProblemaLead WHERE cod_Lead = :idLead";
    $stmt = $conn->prepare($sql_delete_problema);
    $stmt->bindParam(":idLead", $idLead, PDO::PARAM_INT);
    $stmt->execute();

    // Deletar lead (prepared statement)
    $sql_delete_lead = "DELETE FROM tbLeads WHERE id_Lead = :idLead";
    $stmt = $conn->prepare($sql_delete_lead);
    $stmt->bindParam(":idLead", $idLead, PDO::PARAM_INT);
    $stmt->execute();

    // Se todas as operações forem bem-sucedidas, commita a transação
    $conn->commit();

    header("Location: ../plataforma/plataformaLions.php");
  } catch (PDOException $e) {
    // Caso haja algum erro, desfaz as alterações (rollback)
    $conn->rollBack();
    echo "Erro ao excluir lead: " . $e->getMessage();
  } finally {
    // Fecha a conexão com o banco (mesmo em caso de erro)
    $conn = null;
  }
}

//Editar as informações da Lead
function editarInfoLead(int $idLead, $nomeLead, $celLead, $emailLead, $sitLead, $origem, $hora, $descricao)
{
  include './conexao.php';  // Assume que o arquivo conexao.php contém a conexão PDO

  try {
    // Iniciar transação para garantir a integridade dos dados
    $conn->beginTransaction();

    // Atualizar informações da lead (prepared statement)
    $sql = "UPDATE tbLeads SET
        nome = :nomeLead,
        email = :emailLead,
        celular = :celLead,
        cod_origem = :origem,
        cod_horario = :hora
      WHERE id_Lead = :idLead";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":nomeLead", $nomeLead, PDO::PARAM_STR);
    $stmt->bindParam(":emailLead", $emailLead, PDO::PARAM_STR);
    $stmt->bindParam(":celLead", $celLead, PDO::PARAM_STR);
    $stmt->bindParam(":origem", $origem, PDO::PARAM_INT);
    $stmt->bindParam(":hora", $hora, PDO::PARAM_INT);
    $stmt->bindParam(":idLead", $idLead, PDO::PARAM_INT);
    $stmt->execute();

    // Atualizar problema da lead (prepared statement)
    $sql2 = "UPDATE tbProblemaLead SET
        desc_problema = :descricao,
        cod_situacao = :sitLead
      WHERE cod_Lead = :idLead";
    $stmt = $conn->prepare($sql2);
    $stmt->bindParam(":descricao", $descricao, PDO::PARAM_STR);
    $stmt->bindParam(":sitLead", $sitLead, PDO::PARAM_INT);
    $stmt->bindParam(":idLead", $idLead, PDO::PARAM_INT);
    $stmt->execute();

    // Se todas as operações forem bem-sucedidas, commita a transação
    $conn->commit();

    header("Location: ../plataforma/pagDetalhesLead.php?id=$idLead");
  } catch (PDOException $e) {
    // Caso haja algum erro, desfaz as alterações (rollback)
    $conn->rollBack();
    echo "Erro ao editar informações da lead: " . $e->getMessage();
  } finally {
    // Fecha a conexão com o banco (mesmo em caso de exceções)
    $conn = null;
  }
};

function atualizarInvestimento(int $id, $valor)
{
  include 'conexao.php';  // Assume que o arquivo conexao.php contém a conexão PDO

  try {
    // Iniciar transação para garantir a integridade dos dados
    $conn->beginTransaction();

    // Atualizar informações da lead (prepared statement)
    $sql = "UPDATE tbInvestimento SET
        valor = :valorInvestimento
      WHERE id = :id;";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":valorInvestimento", $valor, PDO::PARAM_STR);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    $stmt->execute();

    // Se todas as operações forem bem-sucedidas, commita a transação
    $conn->commit();

    return true;
  } catch (PDOException $e) {
    // Caso haja algum erro, desfaz as alterações (rollback)
    $conn->rollBack();
    echo "Erro ao atualizar investimento: " . $e->getMessage();
  } finally {
    // Fecha a conexão com o banco (mesmo em caso de exceções)
    $conn = null;
  }
};

function getOrigens()
{
  include "conexao.php";

  $sql = "SELECT id_origem, nome_origem FROM tbOrigemLead;";

  $stm = $conn->prepare($sql);
  $stm->execute();

  $resultado = $stm->fetchAll(PDO::FETCH_ASSOC);

  return $resultado;
}
function getFaseOportunidade()
{
  include "conexao.php";

  $sql = "SELECT id_fase, nome_fase FROM tbFaseOportunidade;";

  $stm = $conn->prepare($sql);
  $stm->execute();

  $resultado = $stm->fetchAll(PDO::FETCH_ASSOC);

  return $resultado;
}
function getHorarios()
{
  include "conexao.php";

  $sql = "SELECT id_horario, desc_horario FROM tbHorarioLead;";

  $stm = $conn->prepare($sql);
  $stm->execute();

  $resultado = $stm->fetchAll(PDO::FETCH_ASSOC);

  return $resultado;
}

function getSituacoes()
{
  include "conexao.php";

  $sql = "SELECT id_situacao, nome_situacao FROM tbSituacaoLead;";

  $stm = $conn->prepare($sql);
  $stm->execute();

  $resultado = $stm->fetchAll(PDO::FETCH_ASSOC);

  return $resultado;
}

function getFuncionarios()
{
  include "conexao.php";

  $sql = "SELECT id_funcionario, nome FROM tbFuncionarios WHERE cod_cargo = 4 OR cod_cargo = 3";

  $stm = $conn->prepare($sql);
  $stm->execute();

  $resultado = $stm->fetchAll(PDO::FETCH_ASSOC);

  return $resultado;
}
function getFuncionariosAll()
{
  include "conexao.php";

  $sql = "SELECT id_funcionario, nome FROM tbFuncionarios WHERE cod_departamento = 1";

  $stm = $conn->prepare($sql);
  $stm->execute();

  $resultado = $stm->fetchAll(PDO::FETCH_ASSOC);

  return $resultado;
}
function getFuncionariosCom2()
{
  include "conexao.php";

  $sql = "SELECT id_funcionario, nome FROM tbFuncionarios WHERE cod_departamento = 2";

  $stm = $conn->prepare($sql);
  $stm->execute();

  $resultado = $stm->fetchAll(PDO::FETCH_ASSOC);

  return $resultado;
}
function getFormasPagamento()
{
  include "conexao.php";

  $sql = "SELECT id, nome FROM tbFormaPagamento";

  $stm = $conn->prepare($sql);
  $stm->execute();

  $resultado = $stm->fetchAll(PDO::FETCH_ASSOC);

  return $resultado;
}


// -------------------------- CONSULTAS --------------------------


// Atribui a lead para um funcionário




function consultarDadosLead($idLead)
{
  // **Conexão com o banco de dados**
  include "conexao.php";

  // **Inicia a sessão se não estiver iniciada**
  if (!isset($_SESSION)) {
    session_start();
  }

  try {
    // Query SQL
    $sql = "SELECT 
                l.nome, -- Nome da Lead
                l.email, -- Email da Lead
                l.celular, -- Celular da Lead
                l.data_recebimento, -- Data de cadastro da Lead
                l.cod_horario, -- Melhor horário informado para entrar em contato
                l.cod_funcionario,
                o.id_origem, -- ID da origem que chegou a Lead
                o.nome_origem, -- Nome da origem que chegou a Lead
                s.nome_situacao, -- Situação da Lead
                p.desc_problema, -- Descrição do Problema informado pela Lead
                f.nome AS consultor, -- Nome do Consultor que está responsável pela Lead
                r.data_protocolo, -- Data que foi iniciado o registro do consultor para Lead
                z.nome_fase -- Nome da fase em que a lead está para o consultor
            FROM tbLeads l
            INNER JOIN tbProblemaLead p ON l.id_Lead = p.cod_lead
            INNER JOIN tbSituacaoLead s ON p.cod_situacao = s.id_situacao
            INNER JOIN tbOrigemLead o ON l.cod_origem = o.id_origem
            LEFT JOIN tbFuncionarios f ON l.cod_funcionario = f.id_funcionario
            LEFT JOIN tbRetornos r ON l.id_Lead = r.cod_Lead
            LEFT JOIN tbFaseLead z ON r.cod_fase = z.id_fase
            WHERE l.id_Lead = :idLead";

    // Preparar a consulta
    $stmt = $conn->prepare($sql);

    // Bind do parâmetro
    $stmt->bindParam(':idLead', $idLead, PDO::PARAM_INT);

    // Executar a consulta
    $stmt->execute();

    // Verificar se o lead existe
    if ($stmt->rowCount() == 0) {
      echo "Lead não encontrado.";
      exit;
    }

    // Obter dados do lead
    $lead = $stmt->fetch(PDO::FETCH_ASSOC);

    return $lead;
  } catch (PDOException $e) {
    // Registra o erro em um log
    error_log("Erro ao obter lead: " . $e->getMessage());

    // Exibe uma mensagem de erro genérica
    echo "Erro ao obter lead.";
  }
}

function verificarNotificacaoNova()
{
  include "conexao.php";

  // **Recupera o ID do funcionário da sessão**
  $id_funcionario = $_SESSION['Id_Funcionario'];

  $sql = "SELECT * FROM tbNotificacao WHERE cod_funcionario = :funcionario AND status = 0";

  $stm = $conn->prepare($sql);
  $stm->bindParam(':funcionario', $id_funcionario, PDO::PARAM_INT);

  $stm->execute();

  if ($stm->rowCount() > 0) {
    return true;
  } else {
    return false;
  }
}

function marcarNotificacaoLida()
{
  include "conexao.php";

  // **Recupera o ID do funcionário e do cargo da sessão**
  $id_funcionario = $_SESSION['Id_Funcionario'];
  $cargo = $_SESSION['Cargo'];

  $sql = "UPDATE tbNotificacao SET status = 1 WHERE cod_funcionario = :funcionario";

  $stm = $conn->prepare($sql);
  $stm->bindParam(':funcionario', $id_funcionario, PDO::PARAM_INT);
  $stm->execute();

  // Filtro a partir do cargo do usuário
  switch ($cargo) {
    case 1:
    case 2:
    case 3:
      header("Location: ../plataforma/plataformaLions.php?fase=SemRetorno&consultor=$id_funcionario");
      break;
    case 4:
    case 5:
      header("Location: ../plataforma/plataformaLions.php?fase=SemRetorno");
      break;
  };
}

function consultarMelhorHorarioLead($cod_horario)
{
  include "conexao.php";

  try {
    $sql_horario = "SELECT desc_horario FROM tbHorarioLead WHERE id_horario = :cod_horario";
    $stmt_horario = $conn->prepare($sql_horario);
    $stmt_horario->bindParam(':cod_horario', $cod_horario, PDO::PARAM_INT);
    $stmt_horario->execute();

    $horario = $stmt_horario->fetch(PDO::FETCH_ASSOC);

    echo $horario['desc_horario'];
  } catch (PDOException $e) {
    // Registra o erro em um log
    error_log("Erro ao obter melhor horário: " . $e->getMessage());

    // Exibe uma mensagem de erro genérica
    echo "Erro ao obter melhor horário.";
  }
}

function consultarRetornosLead($idLead)
{
  include "conexao.php";

  try {
    $sql_registros = "SELECT
        r.observacao,
        r.data_protocolo,
        z.nome_fase AS fase
    FROM tbRetornos r
    INNER JOIN tbFaseLead z ON r.cod_fase = z.id_fase
    WHERE r.cod_lead = :idLead
    ORDER BY r.data_protocolo DESC";

    $stmt = $conn->prepare($sql_registros);
    $stmt->bindParam(':idLead', $idLead, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      while ($retorno = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $fase = $retorno['fase'];
        $data_mysql = strtotime($retorno["data_protocolo"]);
        $data_formatada = date("d/m/Y", $data_mysql);
        $observacao = $retorno['observacao'];

        echo "<div class='lista_obs'>
                <div class='linha_obs'>
                  <h4>$fase</h4>
                  <span>$data_formatada</span>
                </div>

                <div class='desc_obs'>$observacao</div>
              </div>";
      }
    } else {
      echo "";
    }
  } catch (PDOException $e) {
    // Registra o erro em um log
    error_log("Erro ao obter observações: " . $e->getMessage());

    // Exibe uma mensagem de erro genérica
    echo "Erro ao obter observações.";
  }
}

function pesquisaLeadsSuper($tipo, $pesquisa)
{
  include "conexao.php";

  // Construir a consulta SQL
  $sql = "SELECT
        l.id_Lead,
        l.nome,
        l.data_recebimento,
        l.data_modificacao,
        l.cod_funcionario,
        l.celular,
        o.nome_origem,
        f.nome AS funcionario,
        fl.nome_fase AS fase,
        MAX(rt.data_protocolo) AS ultima_data_retorno
    FROM
        tbLeads l
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
  WHERE l." . $tipo . " LIKE '%" . $pesquisa . "%'
  GROUP BY
  l.id_Lead
  ORDER BY
  ultima_data_retorno DESC, l.id_Lead DESC";

  // Preparar e executar a consulta
  $stmt = $conn->prepare($sql);
  $stmt->execute();

  // Obter os resultados da consulta
  $leads = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Verificar se há leads
  if (empty($leads)) {
    return array(); // Retorna um array vazio se não houver leads encontradas
  }

  // Retorna os resultados da consulta
  return $leads;
}

function pesquisaLeadsAtribuidas($tipo, $pesquisa, $id_funcionario)
{
  include "conexao.php";

  // Construir a consulta SQL
  $sql = "SELECT
        l.id_Lead,
        l.nome,
        l.data_recebimento,
        l.data_modificacao,
        l.cod_funcionario,
        l.celular,
        o.nome_origem,
        f.nome AS funcionario,
        fl.nome_fase AS fase,
        MAX(rt.data_protocolo) AS ultima_data_retorno
    FROM
        tbLeads l
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
      WHERE l.cod_funcionario = $id_funcionario AND l." . $tipo . " LIKE '%" . $pesquisa . "%'
    GROUP BY
        l.id_Lead
    ORDER BY
        ultima_data_retorno DESC, l.id_Lead DESC";

  // Preparar e executar a consulta
  $stmt = $conn->prepare($sql);
  $stmt->execute();

  // Obter os resultados da consulta
  $leads = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Verificar se há leads
  if (empty($leads)) {
    return array(); // Retorna um array vazio se não houver leads encontradas
  }

  // Retorna os resultados da consulta
  return $leads;
}

function consultarLeadsSuper($inicio = null, $registros = null)
{
  include "conexao.php";

  try {
    $filtroFase = isset($_GET['fase']) ? $_GET['fase'] : 'Todos';

    switch ($filtroFase) {
      case 'SemContato':
        $filtroFase = 'Sem contato';
        break;
      case 'QuerNada':
        $filtroFase = 'Não queria nada';
        break;
      case 'SemAjuda':
        $filtroFase = 'Não podemos ajudar';
        break;
      case 'Regularizado':
        $filtroFase = 'Problema já solucionado';
        break;
      case 'EmAberto':
        $filtroFase = 'Em aberto';
        break;
      case 'Negociacao':
        $filtroFase = 'Negociação';
        break;
      case 'Venda':
        $filtroFase = 'Venda';
        break;
      case 'Mensagem':
        $filtroFase = 'Enviado mensagem';
        break;
      case 'NaoResponde':
        $filtroFase = 'Parou de responder';
        break;
      case 'AchouCaro':
        $filtroFase = 'Achou muito caro';
        break;
      case 'SemRetorno':
        $filtroFase = 'Sem Retorno'; // Não aplicar filtro de fase
        break;
      default:
        $filtroFase = null; // Nenhum filtro específico selecionado
        break;
    }

    $filtroConsultor = isset($_GET['consultor']) ? $_GET['consultor'] : '';
    $filtroData = isset($_GET['data']) ? $_GET['data'] : '';
    $filtroOrigem = isset($_GET['origem']) ? $_GET['origem'] : '';
    $filtroDataFinal = isset($_GET['dataFinal']) ? $_GET['dataFinal'] : '';
    $filtroSituacao = isset($_GET['situacao']) ? $_GET['situacao'] : '';

    // $where = "WHERE fl.nome_fase not in ('Sem Contato')";
    $where = "";
    $params = array();

    if ($filtroFase !== null) {
      if ($filtroFase === 'Sem Retorno') {
        // Se o filtro for 'SemRetorno', inclui leads sem retorno na tbRetornos
        $where = "WHERE NOT EXISTS (
                          SELECT 1 FROM tbRetornos rt
                          WHERE rt.cod_lead = l.id_Lead
                      )";
      } else {
        $where = "WHERE fl.nome_fase = :nome_fase";
        $params[':nome_fase'] = $filtroFase;
      }
    }

    if ($filtroConsultor !== '') {
      $where .= ($where !== '' ? ' AND' : ' WHERE') . " l.cod_funcionario = :cod_funcionario";
      $params[':cod_funcionario'] = $filtroConsultor;
    }

    // Verifica se filtroDataFinal está definido e não vazio
    if ($filtroDataFinal !== '') {
      // Adicionar filtro por intervalo de datas
      $where .= ($where !== '' ? ' AND' : ' WHERE') . " DATE(l.data_recebimento) BETWEEN :data_inicial AND :data_final";
      $params[':data_inicial'] = $filtroData;
      $params[':data_final'] = $filtroDataFinal;
    } elseif ($filtroData !== '') {
      // Adicionar filtro por data única
      $where .= ($where !== '' ? ' AND' : ' WHERE') . " DATE(l.data_recebimento) = :data_recebimento";
      $params[':data_recebimento'] = $filtroData;
    }


    if ($filtroOrigem !== '') {
      $where .= ($where !== '' ? ' AND' : ' WHERE') . " l.cod_origem = :cod_origem";
      $params[':cod_origem'] = $filtroOrigem;
    }
    if ($filtroSituacao !== '') {
      $where .= ($where !== '' ? ' AND' : ' WHERE') . " p.cod_situacao = :cod_situacao";
      $params[':cod_situacao'] = $filtroSituacao;
    }
    $limitar = "";

    if ($inicio !== null) {
      $limitar = "LIMIT $inicio, $registros;";
    }
    // Construir a consulta SQL
    $sql = "SELECT
                    l.id_Lead,
                    l.nome,
                    l.celular,
                    l.data_recebimento,
                    l.data_modificacao,
                    l.cod_funcionario,
                    o.nome_origem,
                    s.nome_situacao,
                    p.cod_situacao,
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
                    ultima_data_retorno DESC, l.id_Lead DESC
                    $limitar";

    // Preparar e executar a consulta
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    // Obter os resultados da consulta
    $leads = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Verificar se há leads
    if (empty($leads)) {
      return array(); // Retorna um array vazio se não houver leads encontradas
    }

    // Retorna os resultados da consulta
    return $leads;
  } catch (PDOException $e) {
    // Registra o erro em um log
    error_log("Erro ao obter leads: " . $e->getMessage());

    // Lança uma exceção para ser capturada no código que chama esta função
    throw new Exception("Erro ao obter leads.");
  }
}

function consultarPontos()
{
  include "conexao.php";
  // Obtém o mês atual como número inteiro
  $mes = date('m');

  // Consulta SQL para buscar os pontos do mês
  $sql = "SELECT DATE(p.horario) AS dia_ponto, f.nome, TIME(p.horario) AS horario 
            FROM tbPonto p
            INNER JOIN tbFuncionarios f ON p.cod_funcionario = f.id_funcionario
            INNER JOIN tbPalavrasChave pc ON p.cod_palavra = pc.id_palavra
            WHERE MONTH(pc.data_cadastro) = :mes";

  // Prepara a consulta
  $stmt = $conn->prepare($sql);

  // Liga o parâmetro do mês
  $stmt->bindParam(":mes", $mes, PDO::PARAM_STR);

  // Executa a consulta
  $stmt->execute();

  // Obtém os resultados
  $pontos = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Retorna os resultados ou um array vazio
  return $pontos ?: [];
}

function consultarVendasCom1()
{
  include "conexao.php";

  // Consulta SQL para buscar os pontos do mês
  $sql = "SELECT v.valor, v.data_venda, f.nome from tbVendas v INNER JOIN tbFuncionarios f ON v.";

  $sql = "SELECT DATE(p.horario) AS dia_ponto, f.nome, TIME(p.horario) AS horario 
  FROM tbPonto p
  INNER JOIN tbFuncionarios f ON p.cod_funcionario = f.id_funcionario
  INNER JOIN tbPalavrasChave pc ON p.cod_palavra = pc.id_palavra
  WHERE MONTH(pc.data_cadastro) = :mes";

  // Prepara a consulta
  $stmt = $conn->prepare($sql);

  // Liga o parâmetro do mês
  $stmt->bindParam(":mes", $mes, PDO::PARAM_STR);

  // Executa a consulta
  $stmt->execute();

  // Obtém os resultados
  $pontos = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Retorna os resultados ou um array vazio
  return $pontos ?: [];
}

function consultarTotalLeadsSuper()
{
  include "conexao.php";

  try {
    $mes = date('m');
    $ano = date('Y');
    $filtroFase = isset($_GET['fase']) ? $_GET['fase'] : 'Todos';

    // Fase de filtro (não alterado)
    switch ($filtroFase) {
      case 'SemContato':
        $filtroFase = 'Sem contato';
        break;
      case 'QuerNada':
        $filtroFase = 'Não queria nada';
        break;
      case 'SemAjuda':
        $filtroFase = 'Não podemos ajudar';
        break;
      case 'Regularizado':
        $filtroFase = 'Problema já solucionado';
        break;
      case 'EmAberto':
        $filtroFase = 'Em aberto';
        break;
      case 'Negociacao':
        $filtroFase = 'Negociação';
        break;
      case 'Venda':
        $filtroFase = 'Venda';
        break;
      case 'Mensagem':
        $filtroFase = 'Enviado mensagem';
        break;
      case 'NaoResponde':
        $filtroFase = 'Parou de responder';
        break;
      case 'AchouCaro':
        $filtroFase = 'Achou muito caro';
        break;
      case 'SemRetorno':
        $filtroFase = 'Sem Retorno'; // Não aplicar filtro de fase
        break;
      default:
        $filtroFase = null; // Nenhum filtro específico selecionado
        break;
    }

    $filtroConsultor = isset($_GET['consultor']) ? $_GET['consultor'] : '';
    $filtroData = isset($_GET['data']) ? $_GET['data'] : '';
    $filtroOrigem = isset($_GET['origem']) ? $_GET['origem'] : '';
    $filtroDataFinal = isset($_GET['dataFinal']) ? $_GET['dataFinal'] : '';
    $filtroSituacao = isset($_GET['situacao']) ? $_GET['situacao'] : '';

    $where = "";
    $params = array();

    if ($filtroFase !== null) {
      if ($filtroFase === 'Sem Retorno') {
        $where = "WHERE NOT EXISTS (
                          SELECT 1 FROM tbRetornos rt
                          WHERE rt.cod_lead = l.id_Lead
                      )";
      } else {
        $where = "WHERE fl.nome_fase = :nome_fase";
        $params[':nome_fase'] = $filtroFase;
      }
    }

    if ($filtroConsultor !== '') {
      $where .= ($where !== '' ? ' AND' : ' WHERE') . " l.cod_funcionario = :cod_funcionario";
      $params[':cod_funcionario'] = $filtroConsultor;
    }

    if ($filtroDataFinal !== '') {
      $where .= ($where !== '' ? ' AND' : ' WHERE') . " DATE(l.data_recebimento) BETWEEN :data_inicial AND :data_final";
      $params[':data_inicial'] = $filtroData;
      $params[':data_final'] = $filtroDataFinal;
    } elseif ($filtroData !== '') {
      $where .= ($where !== '' ? ' AND' : ' WHERE') . " DATE(l.data_recebimento) = :data_recebimento";
      $params[':data_recebimento'] = $filtroData;
    }

    if ($filtroOrigem !== '') {
      $where .= ($where !== '' ? ' AND' : ' WHERE') . " l.cod_origem = :cod_origem";
      $params[':cod_origem'] = $filtroOrigem;
    }
    if ($filtroSituacao !== '') {
      $where .= ($where !== '' ? ' AND' : ' WHERE') . " p.cod_situacao = :cod_situacao";
      $params[':cod_situacao'] = $filtroSituacao;
    }

    // Modificar a consulta para contar o número de leads
    $sql = "SELECT COUNT(l.id_Lead) AS total_leads
            FROM tbLeads l
            INNER JOIN tbProblemaLead p ON l.id_Lead = p.cod_lead
            INNER JOIN tbSituacaoLead s ON p.cod_situacao = s.id_situacao
            INNER JOIN tbOrigemLead o ON l.cod_origem = o.id_origem
            LEFT JOIN tbFuncionarios f ON l.cod_funcionario = f.id_funcionario
            LEFT JOIN (
                SELECT cod_lead, MAX(data_protocolo) AS max_data_protocolo
                FROM tbRetornos
                GROUP BY cod_lead
            ) rt_max ON l.id_Lead = rt_max.cod_lead
            LEFT JOIN tbRetornos rt ON rt_max.cod_lead = rt.cod_lead AND rt_max.max_data_protocolo = rt.data_protocolo
            LEFT JOIN tbFaseLead fl ON rt.cod_fase = fl.id_fase
            $where ";

    // Preparar e executar a consulta
    $stmt = $conn->prepare($sql);

    $stmt->execute($params);

    // Obter o resultado da contagem
    $totalLeads = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar se há leads
    if (!$totalLeads) {
      return 0; // Se não houver leads, retorna 0
    }

    // Retorna o total de leads encontrados
    return $totalLeads['total_leads'];
  } catch (PDOException $e) {
    // Registra o erro em um log
    error_log("Erro ao obter total de leads: " . $e->getMessage());

    // Lança uma exceção para ser capturada no código que chama esta função
    throw new Exception("Erro ao obter total de leads.");
  }
}

function consultarLeadsAtribuidas($id_funcionario, $inicio = null, $registros = null)
{
  include "conexao.php";

  try {
    $filtroFase = isset($_GET['fase']) ? $_GET['fase'] : 'Todos';
    $filtroData = isset($_GET['data']) ? $_GET['data'] : '';

    // Definir a cláusula WHERE com base no filtro selecionado
    $where = " AND fl.nome_fase != 'Sem contato'";
    $params = array();

    switch ($filtroFase) {
      case 'SemContato':
        $filtroFase = 'Sem contato';
        break;
      case 'QuerNada':
        $filtroFase = 'Não queria nada';
        break;
      case 'SemAjuda':
        $filtroFase = 'Não podemos ajudar';
        break;
      case 'Regularizado':
        $filtroFase = 'Problema já solucionado';
        break;
      case 'EmAberto':
        $filtroFase = 'Em aberto';
        break;
      case 'Negociacao':
        $filtroFase = 'Negociação';
        break;
      case 'Venda':
        $filtroFase = 'Venda';
        break;
      case 'Mensagem':
        $filtroFase = 'Enviado mensagem';
        break;
      case 'NaoResponde':
        $filtroFase = 'Parou de responder';
        break;
      case 'AchouCaro':
        $filtroFase = 'Achou muito caro';
        break;
      case 'SemRetorno':
        $filtroFase = 'Sem Retorno'; // Não aplicar filtro de fase
        break;
      default:
        $filtroFase = null; // Nenhum filtro específico selecionado
        break;
    }

    if ($filtroFase !== null) {
      if ($filtroFase === 'Sem Retorno') {
        // Se o filtro for 'SemRetorno', inclui leads sem retorno na tbRetornos
        $where = " AND NOT EXISTS (
                          SELECT 1 FROM tbRetornos rt
                          WHERE rt.cod_lead = l.id_Lead
                      )";
      } else {
        $where = "AND fl.nome_fase = :nome_fase";
        $params[':nome_fase'] = $filtroFase;
      }
    }

    if ($filtroData !== "") {
      // Adicionar filtro por data de entrada
      $where .= "AND DATE(l.data_recebimento) = :data_recebimento";
      $params[':data_recebimento'] = $filtroData;
    }

    $limitar = "";

    if ($inicio !== null) {
      $limitar = "LIMIT $inicio, $registros;";
    }

    // Executar consulta com paginação
    // Construir a consulta SQL
    $sql = "SELECT
        l.id_Lead,
        l.nome,
        l.data_recebimento,
        l.data_modificacao,
        l.cod_funcionario,
        l.celular,
        o.nome_origem,
        f.nome AS funcionario,
        fl.nome_fase AS fase,
        MAX(rt.data_protocolo) AS ultima_data_retorno
    FROM
        tbLeads l
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
      WHERE l.cod_funcionario = $id_funcionario $where
    GROUP BY
        l.id_Lead
    ORDER BY
        ultima_data_retorno DESC, l.id_Lead DESC
        $limitar";


    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    // Obter os resultados da consulta
    $leads = $stmt->fetchAll(PDO::FETCH_ASSOC);


    if (empty($leads)) {
      return array(); // Retorna um array vazio se não houver leads encontradas
    }

    // Retorna os resultados da consulta
    return $leads;
  } catch (PDOException $e) {
    // Registra o erro em um log
    error_log("Erro ao obter leads: " . $e->getMessage());

    // Exibe uma mensagem de erro genérica
    echo "Erro ao obter leads.";
  }
}

function consultarUltimaFaseLead($idLead)
{
  include "conexao.php";
  // Prepare consulta para obter última fase do lead (prepared statement)
  $sql_registros = "SELECT z.id_fase AS fase FROM tbRetornos r
    INNER JOIN tbFaseLead z ON r.cod_fase = z.id_fase
    WHERE r.cod_lead = :idLead
    ORDER BY r.data_protocolo DESC
    LIMIT 1;";
  $stmt = $conn->prepare($sql_registros);
  // Vincula o parâmetro ao valor
  $stmt->bindParam(":idLead", $idLead, PDO::PARAM_INT);
  // Executa a consulta
  $stmt->execute();

  // Obter o resultado da consulta (máximo 1 registro)
  $retorno = $stmt->fetch(PDO::FETCH_ASSOC);
  $fase = ($retorno) ? $retorno['fase'] : null;
  return $fase;
}
