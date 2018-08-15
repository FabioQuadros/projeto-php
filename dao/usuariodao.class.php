<?php
require 'conexaobanco.class.php';

class UsuarioDAO {

  private $conexao = null;

  public function __construct(){
    $this->conexao = ConexaoBanco::getInstance();
  }

  public function __destruct(){}

  public function cadastrarUsuario($u){
    try {
      $stat = $this->conexao->prepare("insert into usuario(idUsuario,login,senha,tipo)values(null,?,?,?)");
      $stat->bindValue(1,$u->login);
      $stat->bindValue(2,$u->senha);
      $stat->bindValue(3,$u->tipo);
      $stat->execute();
    } catch (PDOException $e) {
      echo "Erro ao cadastrar usuario".$e;
    }
  }

  public function alterarUsuario($u){
    try {
      $stat = $this->conexao->prepare("update usuario set login=?, senha=?, tipo=? where idUsuario=?");
      $stat->bindValue(1,$u->login);
      $stat->bindValue(2,$u->senha);
      $stat->bindValue(3,$u->tipo);
      $stat->bindValue(4,$u->idUsuario);
      $stat->execute();
    } catch (PDOException $e) {
      echo "Erro ao alterar usuario".$e;
    }
  }

  public function buscarUsuario(){
    try{
      $stat = $this->conexao->query("select * from usuario");
      $array = $stat->fetchAll(PDO::FETCH_CLASS, 'Usuario');
  		return $array;
    }catch(PDOException $e){
      echo "Erro ao filtrar usuario! ".$e;
    }
  }

  public function filtrarUsuario($query){
    try{
      $stat = $this->conexao->query("select * from usuario ".$query);
      $array = $stat->fetchAll(PDO::FETCH_CLASS, 'Usuario');
  		return $array;
    }catch(PDOException $e){
      echo "Erro ao filtrar usuario! ".$e;
    }
  }

  public function deletarUsuario($id){
    try {
   $stat = $this->conexao->prepare("delete from usuario where idUsuario = ?");
   $stat->bindValue(1, $id);
   $stat->execute();
    } catch (PDOException $pe) {
   echo "Erro ao excluir!".$pe;
    }
  }

  public function verificarUsuario($u){
    try{
      $stat = $this->conexao->query("select * from usuario where login='$u->login' and senha='$u->senha' and tipo='$u->tipo'");
      $usuario = null;
      $usuario = $stat->fetchObject($usuario);
      return $usuario;
    }catch(PDOException $e){
      echo "Erro ao verificar usuario! ".$e;
    }
  }
}
