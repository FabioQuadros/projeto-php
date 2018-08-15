<?php
session_start();
ob_start();

if(isset($_SESSION['privateUser'])){
  include_once '../modelo/usuario.class.php';
  $u = unserialize($_SESSION['privateUser']);

  if($u->tipo != 'Profissional'){
    header("location:../index.php");
  }
}else{
  header("location:../index.php");
}

include '../modelo/funcionario.class.php';
include '../dao/funcionarioDAO.class.php';
include '../util/padronizacao.class.php';
if (isset($_GET['id'])) {;
  $funDAO = new FuncionarioDAO();
  $query = "where idFuncionario=".$_GET['id'];
  $array = $funDAO->filtrar($query);

  unset($_GET['id']);
}

if(isset($_POST['alterar'])){
  $idFuncionario = $_POST['txtidFuncionario'];
  $nome = Padronizacao::padronizarMaiMin($_POST['txtnome']);
  $cpf = $_POST['txtcpf'];
  $rg =$_POST['txtrg'];
  $data = $_POST['txtdata'];
  $sexo = $_POST['txtsexo'];

  $fun = new Funcionario();
  $fun->idFuncionario = $idFuncionario;
  $fun->nome = $nome;
  $fun->cpf = $cpf;
  $fun->rg = $rg;
  $fun->data = $data;
  $fun->sexo = $sexo;

  $funDAO = new FuncionarioDAO();
  $funDAO->alterarFuncionario($fun);
   header("location:../consultar/consultar-funcionario.php");
}
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
        <form name="alterarfuncionario" method="post" action="">
          <div class="form-group">
            <input type="text" name="txtidFuncionario" placeholder="Código" class="form-control"
            readonly="readonly" value="<?php if(isset($array)) echo $array[0]->idFuncionario?>">
          </div>
          <div class="form-group">
            <input type="text" name="txtnome" placeholder="Nome" class="form-control"
            value="<?php if(isset($array)) echo $array[0]->nomeFuncionario?>">
          </div>
          <div class="form-group">
            <input type="text" name="txtcpf" placeholder="CPF" class="form-control"
            value="<?php if(isset($array)) echo $array[0]->cpf?>">
          </div>
          <div class="form-group">
            <input type="text" name="txtrg" placeholder="RG" class="form-control"
            value="<?php if(isset($array)) echo $array[0]->rg?>">
          </div>
          <div class="form-group">
            <input type="date" name="txtdata" placeholder="Data de nascimento" class="form-control"
            value="<?php if(isset($array)) echo $array[0]->dataFun?>">
          </div>
          <div class="form-group">
           <input type="text" name="txtsexo" placeholder="Sexo" class="form-control"
            value="<?php if(isset($array)) echo $array[0]->sexoFun?>">
          </div>
          <div class="form-group">
            <input type="submit" name="alterar" value="Alterar" class="btn btn-success">
            <input type="reset" name="Limpar" value="Limpar" class="btn btn-primary">
          </div>
        </form>
      </div>
  </body>
</html>
