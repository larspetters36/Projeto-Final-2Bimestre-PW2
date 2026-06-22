<?php
declare(strict_types=1);
require_once 'Despesa.php';
require_once 'Receita.php';

class Carteira {
    private float $saldo;
    private array $transacao;  

    public function __construct() {
        $this->saldo = 0.0;
        $this->transacao = [];

    }

    public function adicionarDespesa(Despesa $despesa): void {
        if ($despesa->getValor() > $this->saldo){
            throw new Exception("Saldo insuficiente.");
        }
        else {
            $this->saldo -= $despesa->getValor();
             $this->transacao[] = $despesa;
        }
        
    }

    public function adicionarReceita(Receita $receita): void {
        $this->saldo += $receita->getValor();
        $this->transacao[] = $receita;
    }

    public function getSaldo(): float {
        return $this->saldo;
    }
    public function getTransacoes(): array {
        return $this->transacao;
    }
}