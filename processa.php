<?php

require_once 'classes/Carteira.php';
session_start();

if (!isset($_SESSION['carteira'])) {
    $_SESSION['carteira'] = new Carteira();
}
$carteira = $_SESSION['carteira'];


$tipo = $_POST['tipo'];
$valor = $_POST['valor'];
$descricao = $_POST['descricao'];

try {
    if ($tipo === 'entrada') {
        $receita = new Receita($valor, $descricao, date('d-m-Y'));
        $carteira->adicionarReceita($receita);
    } elseif ($tipo === 'saida') {
        $despesa = new Despesa($valor, $descricao, date('d-m-Y'));
        $carteira->adicionarDespesa($despesa);
    }
} catch (Exception $e) {
    $_SESSION['erro'] = $e->getMessage();
}

$_SESSION['carteira'] = $carteira;
header('Location: index.php');
exit();