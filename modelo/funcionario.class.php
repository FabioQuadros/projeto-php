<?php
class Funcionario{
  //atributos da classe Funcionario
  private $idFuncionario;
  private $nome;
  private $cpf;
  private $rg;
  private $data;
  private $sexo;

      //metodos construtores
  public function __construct(){}
  public function __destruct(){}

      //entrada de dados
  public function __get ($a){
    return $this->$a;
  }//get

  public function __set($a,$b){
    $this->$a=$b;
  }//set

    //metodo de retorno
  public function __toString(){
    nl2br("idFuncionario: $this->idFuncionario
           Nome: $this->nome
           CPF: $this->cpf
           RG: $this->rg
           Idade: $this->data
           Sexo: $this->sexo");
  }//toString
}//classe
