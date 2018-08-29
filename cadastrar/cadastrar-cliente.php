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

if(isset($_POST['cadastrar'])){
  include '../modelo/cliente.class.php';
  include '../dao/clienteDAO.class.php';
  include '../util/padronizacao.class.php';

  $nome = Padronizacao::padronizarMaiMin($_POST['txtnome']);
  $cpf = Padronizacao::padronizarMaiMin($_POST['txtcpf']);
  $cidade = Padronizacao::padronizarMaiMin($_POST['txtcidade']);
  $estado = $_POST['txtestado'];
  $telefone = $_POST['txttelefone'];

  $cli = new Cliente();
  $cli->nome = $nome;
  $cli->cpf = $cpf;
  $cli->cidade = $cidade;
  $cli->estado = $estado;
  $cli->telefone = $telefone;

  $cliDAO = new ClienteDAO();
  $cliDAO->cadastrarCliente($cli);
  header("location:../consultar/consultar-cliente.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Cadastro de clientes</title>
  </head>
  <body>
    <div class="container">
      <h1 class="jumbotron bg-success">Cadastro de clientes</h1>
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
                <li class="nav-item active"><a class="nav-link" href="../cadastrar/cadastrar-cliente.php">Cadastrar</a></li>
                <li class="nav-item"><a class="nav-link" href="../consultar/consultar-cliente.php">Consultar</a></li>
                <li class="nav-item"><a class="nav-link" href="../filtrar/filtrar-cliente.php">Filtrar</a></li>
              <?php if ($u->tipo == 'Profissional'): ?>
                <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                <li class="nav-item active"><a class="nav-link" href="../cadastrar/cadastrar-cliente.php">Cadastrar</a></li>
                <li class="nav-item"><a class="nav-link" href="../consultar/consultar-cliente.php">Consultar</a></li>
                <li class="nav-item"><a class="nav-link" href="../filtrar/filtrar-cliente.php">Filtrar</a></li>
                <?php if($u->tipo == 'Cliente'): ?>
                  <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                  <li class="nav-item"><a class="nav-link" href="../filtrar/filtrar-cliente.php">Filtrar</a></li>
                <?php endif; ?>
              <?php endif; ?>
            <?php else: ?>
              <li class="active"><a class="nav-link" href="index.php">Home</a></li>
            <?php endif; ?>
            <?php endif; ?>
          </ul>
        </div>
      </nav>
      <form name="cadcli" action="" method="post">
        <div class="form-group">
          <input type="text" class="form-control" name="txtnome" placeholder="Nome"pattern="^[A-z À-ú]{3,45}$" >
        </div>
        <div class="form-group">
          <input type="text" class="form-control" name="txtcpf" placeholder="CPF"pattern="^[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}$" >
        </div>
        <div class="form-group">
          <input type="text" class="form-control" name="txtcidade" placeholder="Cidade"pattern="^[A-z À-ú]{3,45}$" >
        </div>
        <div class="form-group">
          <input type="text" class="form-control" name="txtestado" placeholder="Estado" pattern="^[A-z À-ú]{2,30}$" >
        </div>
        <div class="form-group">
          <input type="text" class="form-control" name="txttelefone" placeholder="Telefone para contato" pattern="^[0-9]{8,13}$" >
        </div>
        <div class="form-group">
          <input type="submit" name="cadastrar" value="Cadastrar" class="btn btn-success">
          <input type="reset" name="limpar" value="Limpar" class="btn btn-primary">
        </div>
      </form>
    </div>
  </body>
</html>
