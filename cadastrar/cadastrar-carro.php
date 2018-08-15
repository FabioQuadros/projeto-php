<?php session_start(); ob_start();
if(isset($_SESSION['privateUser'])){
  include_once '../modelo/usuario.class.php';
  $u = unserialize($_SESSION['privateUser']);

  if($u->tipo != 'Profissional'){
    header("location:../index.php");
  }
}else{
  header("location:../index.php");
}

if(isset($_POST['cadastrar'])){
  include '../modelo/carro.class.php';
  include '../dao/carroDAO.class.php';
  include '../util/padronizacao.php';

  //padronizacao
  $nome = Padronizacao::padronizarMaiMin($_POST['txtnome']);
  $marca = Padronizacao::padronizarMaiMin($_POST['txtmarca']);
  $modelo = Padronizacao::padronizarMaiMin($_POST['txtmodelo']);
  $ano = $_POST['txtano'];
  $cil = $_POST['txtcil'];

  //validacao
  $car = new Carro();
  $car->nome = $nome;
  $car->marca = $marca;
  $car->modelo = $modelo;
  $car->ano = $ano;
  $car->cil = $cil;

  //banco
  $carDAO = new CarroDAO();
  $carDAO->cadastrarCarro($car);
}//fecha if
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Cadastro de carros</title>
  </head>
  <body>
    <div class="container">
      <h1 class="jumbotron bg-success">Cadastro de carros</h1>
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand" href="#">Sistema</a>
          </div>
          <ul class="nav navbar-nav">
            <?php if (isset($_SESSION['privateUser'])): ?>
              <?php include_once '../modelo/usuario.class.php'; ?>
              <?php $u = unserialize($_SESSION['privateUser']); ?>

              <?php if ($u->tipo == 'Profissional'): ?>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../cadastrar/cadastrar-carro.php">Cadastrar</a></li>
                <li><a href="../consultar/consultar-carro.php">Consultar</a></li>
                <li><a href="../filtrar/filtrar-carro.php">Filtrar</a></li>
                <?php if($u->tipo == 'Cliente'): ?>
                  <li><a href="../index.php">Home</a></li>
                <?php endif; ?>
            <?php endif; ?>
          <?php else: ?>
            <li><a href="../index.php">Home</a></li>
          <?php endif; ?>
          </ul>
        </div>
      </nav>
      <form action="" method="post">
        <div class="form-group">
          <input class="form-control" type="text" name="txtnome" placeholder="Nome"pattern="^[A-z À-ú 0-9]{3,45}$">
        </div>
        <div class="form-group">
          <input class="form-control" type="text" name="txtmarca" placeholder="Marca"pattern="^[A-z À-ú]{3,45}$">
        </div>
        <div class="form-group">
          <input class="form-control" type="text" name="txtmodelo" placeholder="Modelo"pattern="^[A-z À-ú 0-9]{1,45}$" >
        </div>
        <div class="form-group">
          <input class="form-control" type="text" name="txtano" placeholder="Ano do carro" pattern="^[0-9]{2,4}$">
        </div>
        <div class="form-group">
          <input class="form-control" type="text" name="txtcil" placeholder="Cilindradas" pattern="^[0-9].{2,4}$">
        </div>
        <div class="form-group">
          <input type="submit" name="cadastrar" value="Cadastrar" class="btn btn-success">
          <input type="reset" name="limpar" value="Limpar" class="btn btn-danger">
        </div>
      </form>
    </div>
  </body>
</html>
