<?php
session_start();ob_start();

if(isset($_SESSION['privateUser'])){
  include_once '../modelo/usuario.class.php';
  $u = unserialize($_SESSION['privateUser']);

  if($u->tipo != 'Profissional'){
    header("location:../index.php");
  }
}else{
  header("location:../index.php");
}

include '../modelo/cliente.class.php';
include '../dao/clienteDAO.class.php';

if (isset($_GET['id'])) {
  $cliDAO = new ClienteDAO();
  $query = "where idCliente=".$_GET['id'];
  $array = $cliDAO->filtrar($query);

  unset($_GET['id']);
}

if(isset($_POST['alterar'])){
  include '../util/padronizacao.class.php';

  //padronizacao
  $idCliente = $_POST['txtidCliente'];
  $nome = Padronizacao::padronizarMaiMin($_POST['txtnome']);
  $cpf = Padronizacao::padronizarMaiMin($_POST['txtcpf']);
  $cidade = Padronizacao::padronizarMaiMin($_POST['txtcidade']);
  $estado = $_POST['txtestado'];
  $telefone = $_POST['txttelefone'];

  //validacao
  $cli = new Cliente();
  $cli->idCliente = $idCliente;
  $cli->nomeCliente = $nome;
  $cli->cpfCliente = $cpf;
  $cli->cidade = $cidade;
  $cli->estado = $estado;
  $cli->telefone = $telefone;

  //banco
  $cliDAO = new ClienteDAO();
  $cliDAO->alterarCliente($cli);
  header("location:../consultar/consultar-cliente.php");
}//fecha if
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <title>Alterar </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
  <body>
      <div class="container">
        <h1 class="jumbotron bg-info">Alterar</h1>

        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <div class="navbar-header">
              <a class="navbar-brand" href="#">Sistema</a>
            </div>
            <ul class="nav navbar-nav">
              <li><a href="index.php">Home</a></li>
              <li><a href="cadastro-cliente.php">Cadastro</a></li>
              <li><a href="consulta-cliente.php">Consulta</a></li>
              <li><a href="filtrar-cliente.php">filtrar</a></li>
              <li class="active"><a href="altrar-cliente.php">alterar</a></li>
            </ul>
          </div>
        </nav>
        <form name="alterarcarro" method="post" action="">
          <div class="form-group">
            <input type="text" name="txtidCliente" placeholder="Código" class="form-control"
            readonly="readonly" value="<?php if(isset($array)) echo $array[0]->idCliente?>">
          </div>
          <div class="form-group">
            <input type="text" name="txtnome" placeholder="Nome" class="form-control"
            value="<?php if(isset($array)) echo $array[0]->nomeCliente?>">
          </div>
          <div class="form-group">
            <input type="text" name="txtcpf" placeholder="CPF" class="form-control"
            value="<?php if(isset($array)) echo $array[0]->cpfCliente?>">
          </div>
          <div class="form-group">
            <input type="text" name="txtcidade" placeholder="Cidade" class="form-control"
            value="<?php if(isset($array)) echo $array[0]->cidade?>">
          </div>
          <div class="form-group">
            <input type="text" name="txtestado" placeholder="Estado" class="form-control"
            value="<?php if(isset($array)) echo $array[0]->estado?>">
          </div>
          <div class="form-group">
           <input type="text" name="txttelefone" placeholder="Telefone" class="form-control"
            value="<?php if(isset($array)) echo $array[0]->telefone?>">
          </div>
          <div class="form-group">
            <input type="submit" name="alterar" value="Alterar" class="btn btn-success">
            <input type="reset" name="Limpar" value="Limpar" class="btn btn-primary">
          </div>
        </form>
      </div>
  </body>
</html>
