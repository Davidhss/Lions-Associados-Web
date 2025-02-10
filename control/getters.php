<?php 

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

function getFuncionariosAll()
{
  include "conexao.php";

  $sql = "SELECT id_funcionario, nome FROM tbFuncionarios";

  $stm = $conn->prepare($sql);
  $stm->execute();

  $resultado = $stm->fetchAll(PDO::FETCH_ASSOC);

  return $resultado;
}
