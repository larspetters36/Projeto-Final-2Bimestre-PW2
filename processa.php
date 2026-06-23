<?php

require_once 'classes/Carteira.php';
session_start();

if (!isset($_SESSION['carteira'])) {
    $_SESSION['carteira'] = new Carteira();
}
$carteira = $_SESSION['carteira'];
try {

$tipo = $_POST['tipo'];
$valor = $_POST['valor'];
$descricao = $_POST['descricao'];

if(empty($tipo) || empty($valor) || empty($descricao)){
    throw new Exception("Preencha todos os campos.");
}else{
    if ($tipo === 'entrada') {
        $receita = new Receita($valor, $descricao, date('d-m-Y'));
        $carteira->adicionarReceita($receita);
    } elseif ($tipo === 'saida') {
        $despesa = new Despesa($valor, $descricao, date('d-m-Y'));
        $carteira->adicionarDespesa($despesa);
    }
}
} catch (Exception $e) {
    $_SESSION['erro'] = $e->getMessage();
}

$_SESSION['carteira'] = $carteira;
header('Location: index.php');
exit();
