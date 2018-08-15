<?php
require 'conexaobanco.class.php';
 class CarroDAO {

   private $conexao = null;

   public function __construct(){
     $this->conexao = ConexaoBanco::getInstance();
   }

   public function __destruct(){}

   public function cadastrarCarro($car){
     try{
     $stat = $this->conexao->prepare("insert into carro(idCarro,nomeCarro,marca,modelo,ano,cil)values(null,?,?,?,?,?)");
     $stat->bindValue(1,$car->nome);
     $stat->bindValue(2,$car->marca);
     $stat->bindValue(3,$car->modelo);
     $stat->bindValue(4,$car->ano);
     $stat->bindValue(5,$car->cil);
     $stat->execute();
   }catch (PDOException $pe){
     echo "ERRO ao cadastrar!!".$pe;
   }
   }//fecha cadastrar
   public function buscarCarro(){
     try {
       $stat = $this->conexao->query("select * from carro");
       $array = $stat->fetchAll(PDO::FETCH_CLASS, 'Carro');
       return $array;
     }catch(PDOException $pe){
       echo "erro ao buscar!".$pe;
     }
   }

   public function filtrarCarro($query){
     try {
       $stat = $this->conexao->query("select * from carro ".$query);
       $array = $stat->fetchAll(PDO::FETCH_CLASS, 'Carro');
       return $array;
     } catch (PDOException $pe) {
       echo "Erro ao filtrar!!".$pe;
     }
   }

   public function deletarCarro($id){
     try {
       $stat = $this->conexao->prepare("delete from carro where idCarro = ?");
       $stat->bindValue(1, $id);
       $stat->execute();
     } catch (PDOException $pe) {
       echo "Erro ao excluir!".$pe;
     }
   }

   public function alterarCarro($car){
     try {
       $stat = $this->conexao->prepare("update carro set nomeCarro=?, marca=?, modelo=?, ano=?, cil=? where idCarro =?");
       $stat->bindValue(1,$car->nomeCarro);
       $stat->bindValue(2,$car->marca);
       $stat->bindValue(3,$car->modelo);
       $stat->bindValue(4,$car->ano);
       $stat->bindValue(5,$car->cil);
       $stat->bindValue(6,$car->idCarro);
       $stat->execute();
     }catch(PDOException $pe){
       echo "Erro ao alterar ! ".$pe;
     }
   }

   public function gerarJSON(){
     try {
       $stat = $this->conexao->query("select * from carro");
       return json_encode($stat->fetchAll(PDO::FETCH_ASSOC));
     } catch (PDOException $pe) {
       echo "Erro ao gerar JSON".$pe;
     }
   }
 }//fecha classe
