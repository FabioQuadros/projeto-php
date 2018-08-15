<?php
include '../dao/carroDAO.class.php';
include '../modelo/carro.class.php';

include '../dao/clienteDAO.class.php';
include '../modelo/cliente.class.php';

include '../dao/funcionarioDAO.class.php';
include '../modelo/funcionario.class.php';

$carDAO = new CarroDAO();
echo $carDAO->gerarJSON();

$cliDAO = new ClienteDAO();
echo $cliDAO->gerarJSON();

$funDAO = new FuncionarioDAO();
echo $funDAO->gerarJSON();
