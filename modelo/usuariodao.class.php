<?php
require 'conexaobanco.class.php';

class UsuarioDAO {
    private $conexao = null;

    public function __construct(){
        $this->conexao = ConexaoBanco::getInstance();
    }
    public function __destruct(){}

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
