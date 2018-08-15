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
if(isset($_POST['cadastrar'])){
  include '../modelo/funcionario.class.php';
  include '../dao/funcionarioDAO.class.php';
  include '../util/padronizacao.class.php';

  $nome = Padronizacao::padronizarMaiMin($_POST['txtnome']);
  $cpf = $_POST['txtcpf'];
  $rg =$_POST['txtrg'];
  $data = $_POST['data'];
  $sexo = $_POST['txtsexo'];

  $fun = new Funcionario();
  $fun->nome = $nome;
  $fun->cpf = $cpf;
  $fun->rg = $rg;
  $fun->data = $data;
  $fun->sexo= $sexo;

  $funDAO = new FuncionarioDAO();
  $funDAO->cadastrarFuncionario($fun);
  header("location:../consultar/consultar-funcionario.php");
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
    <title>Cadastro de Funcionários</title>
  </head>
  <body>
    <div class="container">
      <h1 class="jumbotron bg-success">Cadastro de funcionários</h1>
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
                <li><a href="../cadastrar/cadastrar-funcionario.php">Cadastrar</a></li>
                <li><a href="../consultar/consultar-funcionario.php">Consultar</a></li>
                <li><a href="../filtrar/filtrar-funcionario.php">Filtrar</a></li>
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
          <input type="text" class="form-control"name="txtnome" placeholder="Nome" pattern="^[A-z À-ú]{3,45}$">
        </div>
        <div class="form-group">
          <input type="text" class="form-control"name="txtcpf" placeholder="CPF" pattern="^[0-9]{3}.?[0-9]{3}.?[0-9]{3}-?[0-9]{2}$">
        </div>
        <div class="form-group">
          <input type="text" class="form-control"name="txtrg" placeholder="RG" pattern="^[0-9]{10}$">
        </div>
        <div class="form-group">
          <input class="form-control" name="data" type="date" placeholder="Data de nascimento" />
        </div>
        <div class="form-group">
          <label>Masculino
          <input type="radio" class="radio-inline" name="txtsexo" value="Masculino"></label>
          <label>Feminino
          <input type="radio"class="radio-inline" name="txtsexo" value="Feminino"></label>
        </div>
        <div class="form-group">
          <input type="submit" name="cadastrar" value="Cadastrar" class="btn btn-success">
          <input type="reset" name="limpar" value="Limpar" class="btn btn-primary">
        </div>
      </form>
    </div>
  </body>
</html>
