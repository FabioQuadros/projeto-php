<?php session_start();ob_start();
if(isset($_SESSION['privateUser'])){
  include_once '../modelo/usuario.class.php';
  $u = unserialize($_SESSION['privateUser']);

  if($u->tipo != 'Profissional'){
    header("location:../index.php");
  }
}else{
  header("location:../index.php");
}

include '../dao/clienteDAO.class.php';
include '../modelo/cliente.class.php';

if(isset($_POST['filtrar'])){

  $pesq = "";
  $pesq = $_POST['txtpesquisa'];
  $query = "";

  if($pesq != ""){

    $filtro = $_POST['rdfiltro'];

    if($filtro == 'idcliente'){
      $query = "where idCliente = ".$pesq;
    }else if($filtro == 'nome'){
      $query = "where nomeCliente like '%".$pesq."%'";
    }else if($filtro == 'cpf'){
      $query = "where cpfCliente like '%".$pesq."%'";
    }else if($filtro == 'cidade'){
      $query = "where cidade like '%".$pesq."%'";
    }else if($filtro == 'estado'){
      $query = "where estado like '%".$pesq."%'";
    }else if($filtro == 'telefone'){
      $query = "where telefone like '%".$pesq."%'";
    }else{
      $query = "";
    }
  }

  $cliDAO = new ClienteDAO();
  $array = $cliDAO->filtrar($query);

  unset($_POST['filtrar']);

} else {

  $cliDAO = new ClienteDAO();
  $array = $cliDAO->buscarCliente();
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

              <?php if ($u->tipo == 'Profissional'): ?>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../cadastrar/cadastrar-cliente.php">Cadastrar</a></li>
                <li><a href="../consultar/consultar-cliente.php">Consultar</a></li>
                <li><a href="../filtrar/filtrar-cliente.php">Filtrar</a></li>
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
      <form name="filtrocliente" method="post" action="">
        <div class="form-group">
          <input type="text" name="txtpesquisa" class="form-control"
                 placeholder="Digite o que deseja pesquisar">
        </div>
        <div class="radio-inline">
          <label class="radio-inline">
          <input type="radio" name="rdfiltro" value="idcliente">
          Código</label>
          <label class="radio-inline">
          <input type="radio" name="rdfiltro" value="nome">
          Nome</label>
          <label class="radio-inline">
          <input type="radio" name="rdfiltro" value="cpf">
			    CPF</label>
          <label class="radio-inline">
          <input type="radio" name="rdfiltro" value="cidade">
          Cidade</label>
          <label class="radio-inline">
          <input type="radio" name="rdfiltro" value="estado">
          Estado</label>
          <label class="radio-inline">
          <input type="radio" name="rdfiltro" value="telefone-">
          Telefone</label>
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
              <th>Cidade</th>
              <th>Estado</th>
              <th>Telefone</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($array as $c): ?>
              <tr>
                <td><?=$c->idCliente?></td>
                <td><?=$c->nomeCliente?></td>
                <td><?=$c->cpfCliente?></td>
                <td><?=$c->cidade?></td>
                <td><?=$c->estado?></td>
                <td><?=$c->telefone?></td>
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
