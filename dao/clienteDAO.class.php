<?php
require 'conexaobanco.class.php';
 class ClienteDAO {

   private $conexao = null;

   public function __construct(){
     $this->conexao = ConexaoBanco::getInstance();
   }

   public function __destruct(){}

   public function cadastrarCliente($cli){
     try{
		$stat = $this->conexao->prepare("insert into cliente(idCliente,nomeCliente,cpfCliente,cidade,estado,telefone)values(null,?,?,?,?,?)");
		$stat->bindValue(1,$cli->nome);
		$stat->bindValue(2,$cli->cpf);
		$stat->bindValue(3,$cli->cidade);
		$stat->bindValue(4,$cli->estado);
		$stat->bindValue(5,$cli->telefone);
		$stat->execute();
   }catch (PDOException $pe){
		echo "ERRO ao cadastrar!!".$pe;
   }
   }//fecha cadastrar

   public function buscarCliente(){
     try {
		$stat = $this->conexao->query("select * from cliente");
		$array = $stat->fetchAll(PDO::FETCH_CLASS, 'Cliente');
		return $array;
     }catch(PDOException $pe){
		echo "erro ao buscar!".$pe;
     }
   }

   public function filtrar($query){
     try {
		$stat = $this->conexao->query("select * from cliente ".$query);
		$array = $stat->fetchAll(PDO::FETCH_CLASS, 'Cliente');
		return $array;
     } catch (PDOException $pe) {
		echo "Erro ao filtrar!!".$pe;
     }
   }

   public function deletarCliente($id){
     try {
		$stat = $this->conexao->prepare("delete from cliente where idCliente = ?");
		$stat->bindValue(1, $id);
		$stat->execute();
     } catch (PDOException $pe) {
		echo "Erro ao excluir!".$pe;
     }
   }

   public function alterarCliente($cli){
     try {
		$stat = $this->conexao->prepare("update cliente set nomeCliente=?, cpfCliente=?, cidade=?, estado=?, telefone=? where idCliente =?");
		$stat->bindValue(1,$cli->nomeCliente);
		$stat->bindValue(2,$cli->cpfCliente);
		$stat->bindValue(3,$cli->cidade);
		$stat->bindValue(4,$cli->estado);
		$stat->bindValue(5,$cli->telefone);
    $stat->bindValue(6,$cli->idCliente);
		$stat->execute();
     }catch(PDOException $pe){
		echo "Erro ao alterar ! ".$pe;
     }
   }

   public function gerarJSON(){
     try {
		$stat = $this->conexao->query("select * from cliente");
		return json_encode($stat->fetchAll(PDO::FETCH_ASSOC));
     } catch (PDOException $pe) {
		echo "Erro ao gerar JSON".$pe;
     }
   }
 }//fecha classe
