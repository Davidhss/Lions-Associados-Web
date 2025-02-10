<?php
// Conectar ao banco de dados (substitua os valores conforme necessário)

/*
//Conexão no Locaweb
try {
  $host = "lionsbd.mysql.dbaas.com.br";
  $dbname = "lionsbd";
  $username = "lionsbd";
  $password = "LionsBD#2024";

  $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Erro na conexão: " . $e->getMessage();
}
*/

/*
//Conexão no Hostinger
try {
  $host = "localhost";
  $dbname = "u901394349_database_lions";
  $username = "u901394349_database_lions";
  $password = "GrupoLionsBD#2024";

  $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Erro na conexão: " . $e->getMessage();
}
*/


// Conexão na empresa
$host = "localhost";
$dbname = "BDLionsAssociados";
$username = "root";
$password = "";

$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
/*
$conn = new mysqli(
    "localhost",
    "root",
    "root",
    "BDLionsAssociados"
);
*/
