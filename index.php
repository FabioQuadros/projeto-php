<?php session_start(); ob_start();
if(isset($_POST['entrar'])){

  include_once 'modelo/usuario.class.php';
  include 'dao/usuariodao.class.php';
  include 'util/seguranca.class.php';

  //padronizacao
  $login = $_POST['txtlogin'];
  $senha = Seguranca::criptografar($_POST['txtsenha']);
  $tipo  = $_POST['seltipo'];

  //validacao
  $u = new Usuario();
  $u->login = $login;
  $u->senha = $senha;
  $u->tipo = $tipo;

  $uDAO = new UsuarioDAO();
  $usuario = $uDAO->verificarUsuario($u);

  if($usuario && !is_null($usuario)){

    $_SESSION['privateUser'] = serialize($usuario);
    header("location:index.php");
  }else{

    echo "<div class='alert alert-danger'>
            <strong>Não existe usuário no banco!</strong>
          </div>";
  }
 unset($_POST['entrar']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
  <div class="container">
    <?php if (isset($_SESSION['privateUser'])): ?>
      <?php include_once 'modelo/usuario.class.php'; ?>
      <?php $u = unserialize($_SESSION['privateUser']); ?>
        <h1 class="jumbotron">Seja bem-vindo! <?=$u->login?>
          <form name="deslogar" class="form-group" action="" method="post">
            <div class="form-group">
            <input type="submit" name="deslogar" class="btn btn-primary" value="Deslogar">
            </div>
          </form>
        </h1>
        <?php else: ?>
          <h1 class="jumbotron">Seja bem vindo!</h1>
    <?php endif; ?>

    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">Sistema</a>
        </div>
        <ul class="nav navbar-nav">
          <?php if (isset($_SESSION['privateUser'])): ?>
            <?php include_once 'modelo/usuario.class.php'; ?>
            <?php $u = unserialize($_SESSION['privateUser']); ?>
            <?php if ($u->tipo == 'Adm'): ?>
              <li><a href="../index.php">Home</a></li>
              <li><a href="../cadastrar/cadastrar-usuario.php">Cadastrar</a></li>
              <li><a href="consultar-usuario.php">Consultar</a></li>
              <li><a href="../filtrar/filtrar-usuario.php">Filtrar</a></li>
            <?php if ($u->tipo == 'Profissional'): ?>
              <li><a href="index.php">Home</a></li>
              <li><a href="cadastrar/cadastrar-carro.php">Cadastrar</a></li>
              <li><a href="consultar/consultar-carro.php">Consultar</a></li>
              <li><a href="filtrar/filtrar-carro.php">Filtrar</a></li>
              <?php if($u->tipo == 'Cliente'): ?>
                <li><a href="index.php">Home</a></li>
                <li><a href="cadastrar/cadastrar-carro.php">Cadastro</a></li>
              <?php endif; ?>
            <?php endif; ?>
          <?php else: ?>
            <li><a href="index.php">Home</a></li>
          <?php endif; ?>
          <?php endif; ?>
        </ul>
      </div>
    </nav>
    <?php if (isset($_SESSION['privateUser'])): ?>
      <div class="container">
        <h2>Funções de trabalho</h2>
        <div class="list-group">
          <a href="consultar/consultar-funcionario.php" class="list-group-item">
            <h4 class="list-group-item-heading">Funcionários</h4>
            <p class="list-group-item-text">Clique aqui para seguir em funções dos funcionários</p>
          </a>
          <a href="consultar/consultar-carro.php" class="list-group-item">
            <h4 class="list-group-item-heading">Carros</h4>
            <p class="list-group-item-text">Clique aqui para seguir em funções dos carros</p>
          </a>
          <a href="consultar/consultar-cliente.php" class="list-group-item">
            <h4 class="list-group-item-heading">Clientes</h4>
            <p class="list-group-item-text">Clique aqui para seguir em funções dos clientes</p>
            <a href="consultar/consultar-usuario.php" class="list-group-item">
              <h4 class="list-group-item-heading">Usuários</h4>
              <p class="list-group-item-text">Clique aqui para seguir em funções dos usuários</p>
          </a>
        </div>
      </div>
    <?php endif; ?>

    <?php if (isset($_POST['deslogar'])): ?>
      <?php unset($_SESSION['privateUser']); ?>
      <?php header("location:index.php"); ?>
    <?php endif; ?>

    <?php if (!isset($_SESSION['privateUser'])): ?>
      <!-- INICIO LOGIN -->
      <h2>Login!</h2>
      <form name="login" action="" method="post">
        <div class="form-group form-inline">
          <input type="text" name="txtlogin" placeholder="Login" class="form-control">
        </div>
        <div class="form-group form-inline">
          <input type="password" name="txtsenha" placeholder="Senha" class="form-control">
        </div>
        <div class="form-group form-inline">
          <select name="seltipo" class="form-control">
            <option value="Profissional">Profissional</option>
            <option value="Adm">Administrador</option>
            <option value="Cliente">Cliente</option>
          </select>
        </div>
        <div class="form-group form-inline">
          <input type="submit" name="entrar" value="Entrar" class="btn btn-success">
        </div>
      </form>
      <?php endif; ?>
    </div>
  </body>
</html>
