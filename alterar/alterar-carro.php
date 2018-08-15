<?php
session_start(); ob_start();

if(isset($_SESSION['privateUser'])){
  include_once '../modelo/usuario.class.php';
  $u = unserialize($_SESSION['privateUser']);

  if($u->tipo != 'Profissional'){
    header("location:../index.php");
  }
}else{
  header("location:../index.php");
}

include '../modelo/carro.class.php';
include '../dao/carroDAO.class.php';

if (isset($_GET['id'])) {
  $carDAO = new CarroDAO();
  $query = "where idCarro=".$_GET['id'];
  $array = $carDAO->filtrarCarro($query);

  unset($_GET['id']);
}

if(isset($_POST['alterar'])){

  $idCarro = $_POST['txtidCarro'];
  $nomeCarro = $_POST['txtnome'];
  $marca = $_POST['txtmarca'];
  $modelo =$_POST['txtmodelo'];
  $ano = $_POST['txtano'];
  $cil = $_POST['txtcil'];

  $car = new Carro();
  $car->idCarro = $idCarro;
  $car->nomeCarro = $nomeCarro;
  $car->marca = $marca;
  $car->modelo = $modelo;
  $car->ano = $ano;
  $car->cil = $cil;

  $carDAO = new CarroDAO();
  $carDAO->alterarCarro($car);
  header("location:../consultar/consultar-carro.php");
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
				        <li><a href="index2.php">Home</a></li>
                <li><a href="cadastro-carro.php">Cadastro</a></li>
                <li><a href="consulta-carro.php">Consulta</a></li>
                <li><a href="filtrar-carro.php">filtrar</a></li>
				        <li class="active"><a href="altrar-carro.php">alterar</a></li>
            </ul>
          </div>
        </nav>
        <form name="alterarcarro" method="post" action="">
          <div class="form-group">
            <input type="text" name="txtidCarro" placeholder="Código" class="form-control"
            readonly="readonly" value="<?php if(isset($array)) echo $array[0]->idCarro?>">
          </div>
          <div class="form-group">
            <input type="text" name="txtnome" placeholder="Nome" class="form-control"
            value="<?php if(isset($array)) echo $array[0]->nomeCarro?>">
          </div>
          <div class="form-group">
            <input type="text" name="txtmarca" placeholder="Marca" class="form-control"
            value="<?php if(isset($array)) echo $array[0]->marca?>">
          </div>
          <div class="form-group">
            <input type="text" name="txtmodelo" placeholder="Modelo" class="form-control"
            value="<?php if(isset($array)) echo $array[0]->modelo?>">
          </div>
          <div class="form-group">
            <input type="txt" name="txtano" placeholder="Ano de fabricação" class="form-control"
            value="<?php if(isset($array)) echo $array[0]->ano?>">
          </div>
          <div class="form-group">
           <input type="text" name="txtcil" placeholder="Cilindradas" class="form-control"
            value="<?php if(isset($array)) echo $array[0]->cil?>">
          </div>
          <div class="form-group">
            <input type="submit" name="alterar" value="Alterar" class="btn btn-success">
            <input type="reset" name="Limpar" value="Limpar" class="btn btn-primary">
          </div>
        </form>
      </div>
  </body>
</html>
