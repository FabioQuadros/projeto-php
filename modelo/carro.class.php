<?php
class Carro{
  //atributos do veiculo
  private $idCarro;
  private $nome;
  private $marca;
  private $modelo;
  private $ano;
  private $cil;

    //metodos construtores
  public function __construct(){}
  public function __destruct(){}

      //entrada de dasdos
  public function __get($a){
    return $this->$a;
  }//get

  public function __set($a,$b){
    $this->$a=$b;
  }//set

    //metodo de retorno
  public function __toString(){
    nl2br("IdCarro: $this->idCarro
           Nome: $this->nome
           Marca: $this->marca
           Modelo: $this->modelo
           Ano de fabricação: $this->ano
           Cilindradas: $this->cil");
  }

}//classe
