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
include '../dao/FuncionarioDAO.class.php';
include '../modelo/funcionario.class.php';

if(isset($_POST['filtrar'])){

  $pesq = "";
  $pesq = $_POST['txtpesquisa'];
  $query = "";

  if($pesq != ""){

    $filtro = $_POST['rdfiltro'];

    if($filtro == 'idFuncionario'){
      $query = "where idFuncionario = ".$pesq;
    }else if($filtro == 'nomeFuncionario'){
      $query = "where nomeFuncionario like '%".$pesq."%'";
    }else if($filtro == 'cpf'){
      $query = "where cpf like '%".$pesq."%'";
    }else if($filtro == 'rg'){
      $query = "where rg like '%".$pesq."%'";
    }else if($filtro == 'dataFun'){
      $query = "where dataFun like '%".$pesq."%'";
    }else if($filtro == 'sexoFun'){
      $query = "where sexoFun like '%".$pesq."%'";
    }else{
      $query = "";
    }
  }

  $funDAO = new FuncionarioDAO();
  $array = $funDAO->filtrar($query);

  unset($_POST['filtrar']);
}else {
  $funDAO = new FuncionarioDAO();
  $array = $funDAO->buscarfuncionario();
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
                <li class="nav-item"><a class="nav-link" href="../cadastrar/cadastrar-funcionario.php">Cadastrar</a></li>
                <li class="nav-item"><a class="nav-link" href="../consultar/consultar-funcionario.php">Consultar</a></li>
                <li class="nav-item active"><a class="nav-link" href="../filtrar/filtrar-funcionario.php">Filtrar</a></li>
              <?php if ($u->tipo == 'Profissional'): ?>
                <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="../cadastrar/cadastrar-funcionario.php">Cadastrar</a></li>
                <li class="nav-item "><a class="nav-link" href="../consultar/consultar-funcionario.php">Consultar</a></li>
                <li class="nav-item active"><a class="nav-link" href="../filtrar/filtrar-funcionario.php">Filtrar</a></li>
                <?php if($u->tipo == 'Cliente'): ?>
                  <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                  <li class="nav-item active"><a class="nav-link" href="../filtrar/filtrar-funcionario.php">Filtrar</a></li>
                <?php endif; ?>
              <?php endif; ?>
            <?php else: ?>
              <li class="active"><a class="nav-link" href="index.php">Home</a></li>
            <?php endif; ?>
            <?php endif; ?>
          </ul>
        </div>
      </nav>
      <form name="filtrofuncionario" method="post" action="">
        <div class="form-group">
          <input type="text" name="txtpesquisa" class="form-control"
                 placeholder="Digite o que deseja pesquisar">
        </div>
        <div class="radio-inline">
          <label class="radio-inline">
          <input type="radio" name="rdfiltro" value="idFuncionario">
          Código</label>
          <label class="radio-inline">
          <input type="radio" name="rdfiltro" value="nomeFuncionario">
          Nome</label>
          <label class="radio-inline">
          <input type="radio" name="rdfiltro" value="cpf">
          CPF</label>
          <label class="radio-inline">
          <input type="radio" name="rdfiltro" value="rg">
          RG</label>
          <label class="radio-inline">
          <input type="radio" name="rdfiltro" value="dataFun">
          Data de nascimento</label>
          <label class="radio-inline">
          <input type="radio" name="rdfiltro" value="sexoFun">
          Sexo</label>
          <label class="radio-inline">
          <input type="radio" name="rdfiltro" value="todos" checked="checked">
          Todos</label>
        </div>
        <div class="radio-inline">
          <input type="submit" name="filtrar" value="Filtrar" class="btn btn-primary">
        </div>
      </form>

      <?php if (count($array)!=0): ?>
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
          <thead>
            <tr>
              <th>Código</th>
              <th>Nome</th>
              <th>CPF</th>
              <th>RG</th>
              <th>Data de nascimento</th>
              <th>Sexo</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($array as $f): ?>
              <tr>
                <td><?=$f->idFuncionario?></td>
                <td><?=$f->nomeFuncionario?></td>
                <td><?=$f->cpf?></td>
                <td><?=$f->rg?></td>
                <td><?=$f->dataFun?></td>
                <td><?=$f->sexoFun?></td>
              </tr>
              <?php unset($array); ?>
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
