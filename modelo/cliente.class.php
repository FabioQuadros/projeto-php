<?php
class Cliente{

  //atributos do da classe
  private $idCliente;
  private $nome;
  private $cpf;
  private $cidade;
  private $estado;
  private $telefone;

    //metodos construtores
  public function __construct(){}
  public function __destruct(){}

    //entrada de dados
  public function __get($a){
    return $this->$a;
  }//get

  public function __set($a,$b){
    $this->$a=$b;
  }//set

  public function __toString(){
    nl2br("idCliente:$this->idCliente
           Nome: $this->nome
           CPF: $this->cpf
           Cidade: $this->cidade
           Estado: $this->estado
           Telefone: $this->telefone");
  }
}//classe
