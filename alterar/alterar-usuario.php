<?php session_start();ob_start();
include_once '../modelo/usuario.class.php';
include_once '../dao/usuariodao.class.php';

if (isset($_GET['id'])) {
  $userDAO = new UsuarioDAO();
  $query = "where idUsuario = ".$_GET['id'];
  $array = $userDAO->filtrarUsuario($query);

  unset($_GET['id']);
}

if(isset($_POST['alterar'])){
  include_once '../modelo/usuario.class.php';
  include_once '../dao/usuariodao.class.php';
  include '../util/seguranca.class.php';

  $idUsuario = $_POST['txtidUsuario'];
  $login = $_POST['txtlogin'];
  $senha = Seguranca::criptografar($_POST['txtsenha']);
  $tipo = $_POST['seltipo'];

  $u = new Usuario();
  $u->idUsuario = $idUsuario;
  $u->login = $login;
  $u->senha = $senha;
  $u->tipo = $tipo;

  $uDAO = new UsuarioDAO();
  $uDAO->alterarUsuario($u);

  header("location:../index.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <title>Cadastro de Usuário</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
  <body>
      <div class="container">
        <h1 class="jumbotron bg-info">Cadastro de usuário</h1>
        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <div class="navbar-header">
              <a class="navbar-brand" href="#">Sistema</a>
            </div>
            <ul class="nav navbar-nav">
              <?php if (isset($_SESSION['privateUser'])): ?>
                <?php include_once '../modelo/usuario.class.php'; ?>
                <?php $u = unserialize($_SESSION['privateUser']); ?>

                <?php if ($u->tipo == 'Profissional' && 'Adm'): ?>
                  <li><a href="../index.php">Home</a></li>
                  <li><a href="../cadastrar/cadastrar-usuario.php">Cadastro</a></li>
                  <li><a href="../consultar/consultar-usuario.php">Consulta</a></li>
                  <li><a href="../filtrar/filtrar-usuario.php">filtrar</a></li>
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
        <form  method="post" action="">
          <div class="form-group">
            <input type="text" name="txtidUsuario"value="<?php if (isset($array)) echo $array[0]->idUsuario; ?>" placeholder="Codigo" class="form-control">
          </div>
          <div class="form-group">
            <input type="text" name="txtlogin"value="<?php if (isset($array)) echo $array[0]->login; ?>" placeholder="Login" class="form-control">
          </div>
          <div class="form-group">
            <input type="password" name="txtsenha" value="<?php if (isset($array)) echo$array[0]->senha; ?>"placeholder="Senha" class="form-control">
          </div>
          <div class="form-group">
            <select name="seltipo" class="form-control">
              <option value="Profissional"<?php if(isset($array))if($array[0]->tipo == "Profissional") echo "selected='selected'"?>>Profissional</option>
              <option value="Adm"<?php if(isset($array))if($array[0]->tipo == "Adm") echo "selected='selected'"?>>Administrador</option>
              <option value="Cliente"<?php if(isset($array))if($array[0]->tipo == "Cliente") echo "selected='selected'"?>>Cliente</option>
            </select>
          </div>
          <div class="form-group">
            <input type="submit" name="alterar" value="Alterar" class="btn btn-success">
            <input type="reset" name="Limpar" value="Limpar" class="btn btn-primary">
          </div>
        </form>
      </div>
  </body>
</html>
