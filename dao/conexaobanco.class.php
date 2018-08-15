<?php
class ConexaoBanco extends PDO {

  private static $instance = null;

  public function __construct($dsn,$user,$pass){

      parent::__construct($dsn,$user,$pass);
  }
  public static function getInstance(){
    if(!isset(self::$instance)){
      try{

        self::$instance = new ConexaoBanco("mysql:dbname=concessionaria;host=localhost","root","fabiodb");
      }catch(PDOException $e){
        echo "Erro ao conectar! ".$e;
      }
    }
    return self::$instance;
  }
}
