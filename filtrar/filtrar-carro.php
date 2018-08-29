<?php session_start();ob_start();
if(isset($_SESSION['privateUser'])){
  include_once '../modelo/usuario.class.php';
  $u = unserialize($_SESSION['privateUser']);

  if($u->tipo != 'Adm' && 'Profissional'){
    header("location:../index.php");
  }
}else{
  header("location:../index.php");
}
if(isset($_SESSION['privateUser'])){
  include_once '../modelo/usuario.class.php';
  $u = unserialize($_SESSION['privateUser']);

  if($u->tipo != 'Adm'){
    header("location:../index.php");
  }
}else{
  header("location:../index.php");
}

include '../dao/carroDAO.class.php';
include '../modelo/carro.class.php';

if(isset($_POST['filtrar'])){

  $pesq = "";
  $pesq = $_POST['txtpesquisa'];
  $query = "";

  if($pesq != ""){

    $filtro = $_POST['rdfiltro'];

    if($filtro == 'idCarro'){
      $query = "where idCarro = ".$pesq;
    }else if($filtro == 'nomeCarro'){
      $query = "where nomeCarro like '%".$pesq."%'";
    }else if($filtro == 'marca'){
      $query = "where marca like '%".$pesq."%'";
    }else if($filtro == 'modelo'){
      $query = "where modelo like '%".$pesq."%'";
    }else if($filtro == 'ano'){
      $query = "where ano like '%".$pesq."%'";
    }else if($filtro == 'cil'){
      $query = "where cil like '%".$pesq."%'";
    }else{
      $query = "";
    }
  }

  $carDAO = new CarroDAO();
  $array = $carDAO->filtrarCarro($query);

  unset($_POST['filtrar']);

} else {
  $carDAO = new CarroDAO();
  $array = $carDAO->buscarCarro();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <title>Filtro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
  <body>
    <div class="container">
      <h1 class="jumbotron bg-info">Filtro</h1>

      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand" href="#">Sistema</a>
          </div>
          <ul class="nav navbar-nav">
            <?php if (isset($_SESSION['privateUser'])): ?>
              <?php include_once '../modelo/usuario.class.php'; ?>
              <?php $u = unserialize($_SESSION['privateUser']); ?>
              <?php if ($u->tipo == 'Adm'): ?>
                <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="../cadastrar/cadastrar-carro.php">Cadastrar</a></li>
                <li class="nav-item"><a class="nav-link" href="../consultar/consultar-carro.php">Consultar</a></li>
                <li class="nav-item active"><a class="nav-link" href="../filtrar/filtrar-carro.php">Filtrar</a></li>
              <?php if ($u->tipo == 'Profissional'): ?>
                <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="../cadastrar/cadastrar-carro.php">Cadastrar</a></li>
                <li class="nav-item "><a class="nav-link" href="../consultar/consultar-carro.php">Consultar</a></li>
                <li class="nav-item active"><a class="nav-link" href="../filtrar/filtrar-carro.php">Filtrar</a></li>
                <?php if($u->tipo == 'Cliente'): ?>
                  <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                  <li class="nav-item active"><a class="nav-link" href="../filtrar/filtrar-carro.php">Filtrar</a></li>
                <?php endif; ?>
              <?php endif; ?>
            <?php else: ?>
              <li class="active"><a class="nav-link" href="index.php">Home</a></li>
            <?php endif; ?>
            <?php endif; ?>
          </ul>
        </div>
      </nav>

      <form name="filtrocarro" method="post" action="">
        <div class="form-group">
          <input type="text" name="txtpesquisa" class="form-control"placeholder="Digite o que deseja pesquisar">
        </div>
        <div class="radio-inline">
          <label class="radio-inline">
          <input type="radio" name="rdfiltro" value="idCarro">
          Código
          </label>
          <label class="radio-inline">
          <input type="radio" name="rdfiltro" value="nomeCarro">
          Nome
        </label>
          <label class="radio-inline">
          <input type="radio" name="rdfiltro" value="marca">
          Marca
        </label>
          <label class="radio-inline">
          <input type="radio" name="rdfiltro" value="modelo">
          Modelo
        </label>
          <label class="radio-inline">
          <input type="radio" name="rdfiltro" value="ano">
          Ano de Fabricação
        </label>
          <label class="radio-inline">
          <input type="radio" name="rdfiltro" value="cil">
          Cilidradas
        </label>
          <label class="radio-inline">
          <input type="radio" name="rdfiltro" value="todos" checked="checked">
          Todos
        </label>
        </div>
        <div class="radio-inline">
          <input type="submit" name="filtrar" value="Filtrar" class="btn btn-primary">
        </div>
      </form>
      <?php if (count($array) != 0): ?>
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
          <thead>
            <tr>
              <th>Código</th>
              <th>Nome</th>
              <th>Marca</th>
              <th>Modelo</th>
              <th>Ano de fabricação</th>
              <th>Cilindradas</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($array as $c): ?>
              <tr>
              <td><?=$c->idCarro?></td>
              <td><?=$c->nomeCarro?></td>
              <td><?=$c->marca?></td>
              <td><?=$c->modelo?></td>
              <td><?=$c->ano?></td>
              <td><?=$c->cil?></td>
              </tr>
            <?php unset($array);?>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
        <?php else: ?>
      <div class="alert alert-info">
        <strong>Não há arquivos(s) para ser(em) exibidos!</strong>
      </div>
      <?php endif; ?>
    </div>
  </body>
</html>
