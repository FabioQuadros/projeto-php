<?php
require 'conexaobanco.class.php';
 class FuncionarioDAO {

   private $conexao = null;

   public function __construct(){
     $this->conexao = ConexaoBanco::getInstance();
   }

   public function __destruct(){}

   public function cadastrarFuncionario($fun){
     try{
  		$stat = $this->conexao->prepare("insert into funcionario(idFuncionario,nomeFuncionario,cpf,rg,dataFun,sexoFun)values(null,?,?,?,?,?)");
  		$stat->bindValue(1,$fun->nome);
  		$stat->bindValue(2,$fun->cpf);
  		$stat->bindValue(3,$fun->rg);
  		$stat->bindValue(4,$fun->data);
  		$stat->bindValue(5,$fun->sexo);
  		$stat->execute();
   }catch (PDOException $pe){
  		echo "ERRO ao cadastrar!".$pe;
   }
  }

   public function buscarFuncionario(){
     try {
       $stat = $this->conexao->query("select * from funcionario");
       $array = $stat->fetchAll(PDO::FETCH_CLASS, 'Funcionario');
       return $array;//NÃO ESQUECER
     }catch(PDOException $pe){
       echo "erro ao buscar!".$pe;
     }
   }

   public function filtrar($query){
     try {
		   $stat = $this->conexao->query("select * from funcionario ".$query);
		   $array = $stat->fetchAll(PDO::FETCH_CLASS, 'Funcionario');
		   return $array;
     } catch (PDOException $pe) {
			echo "Erro ao filtrar!!".$pe;
     }
   }

   public function deletarFuncionario($id){
     try {
		   $stat = $this->conexao->prepare("delete from funcionario where idFuncionario = ?");
		   $stat->bindValue(1, $id);
		   $stat->execute();
     } catch (PDOException $pe) {
		   echo "Erro ao excluir!".$pe;
     }
   }

   public function alterarFuncionario($fun){
     try {
		 $stat = $this->conexao->prepare("update funcionario set nomeFuncionario=?, cpf=?, rg=?, dataFun=?, sexoFun=? where idFuncionario =?");
		 $stat->bindValue(1,$fun->nome);
		 $stat->bindValue(2,$fun->cpf);
		 $stat->bindValue(3,$fun->rg);
		 $stat->bindValue(4,$fun->data);
		 $stat->bindValue(5,$fun->sexo);
     $stat->bindValue(6,$fun->idFuncionario);
		 $stat->execute();
     }catch(PDOException $pe){
		 echo "Erro ao alterar ! ".$pe;
     }
   }//metodo

   public function gerarJSON(){
     try {
		   $stat = $this->conexao->query("select * from funcionario");
		   return json_encode($stat->fetchAll(PDO::FETCH_ASSOC));
     } catch (PDOException $pe) {
            echo "Erro ao gerar JSON".$pe;
     }//cath
   }//json
 }//fecha classe
