<?php

require_once 'conexao.php';
require_once 'classes/Transacao.php';
require_once 'classes/Receita.php';
require_once 'classes/Despesa.php';
require_once 'classes/Carteira.php';

session_start();


if (!isset($_SESSION['carteira'])) {
    $_SESSION['carteira'] = new Carteira();
}

$carteira = $_SESSION['carteira'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'cadastrar') {
    $tipo = trim($_POST['tipo']);
    $valor = trim($_POST['valor']);
    $descricao = trim($_POST['descricao']);

    if (!empty($tipo) && !empty($valor) && !empty($descricao)) {
        $stmt = $pdo->prepare("INSERT INTO transacoes (tipo, valor, descricao) VALUES (:tipo, :valor, :descricao)");
        $stmt->execute(['tipo' => $tipo, 'valor' => $valor, 'descricao' => $descricao]);
        header('Location: index.php');
        exit;
    }
}
$stmt = $pdo->query("SELECT * FROM transacoes ORDER BY id DESC");
$transacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Pocket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body class="bg-light">

<div class="container py-5">
<?php if (isset($_SESSION['erro'])): ?>

    <div class="alert alert-danger">
        <?= $_SESSION['erro'] ?>
    </div>

    <?php unset($_SESSION['erro']); ?>

<?php endif; ?>
    <!-- Saldo -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body text-center">
            <h6 class="text-muted mb-2">Saldo Atual</h6>
            <h1 class="fw-bold text-success">
                R$ <?= number_format($carteira->getSaldo(), 2, ',', '.') ?>
            </h1>
        </div>
    </div>

    <div class="row">

        <!-- Formulário -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    Nova Transação
                </div>

                <div class="card-body">

                    <form method="POST" >

                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Tipo da Transação
                            </label>

                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="tipo"
                                    id="receita"
                                    value="Entrada"
                                    checked>

                                <label class="form-check-label" for="receita">
                                    Receita
                                </label>
                            </div>

                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="tipo"
                                    id="despesa"
                                    value="Saída">

                                <label class="form-check-label" for="despesa">
                                    Despesa
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Valor</label>
                            <input
                                type="text"
                                name="valor"
                                class="form-control"
                                placeholder="R$ 0,00">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descrição</label>
                            <input
                                type="text"
                                name="descricao"
                                class="form-control"
                                placeholder="Ex: Mercado">
                        </div>

                        <button class="btn btn-primary w-100">
                            Salvar Transação
                        </button>

                    </form>

                </div>
            </div>
        </div>

        <!-- Histórico -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Histórico de Transações</h5>
                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Tipo</th>
                                    <th>Valor</th>
                                    <th>Descrição</th>
                                    <th>Data</th>
                                </tr>
                            </thead>

                            <tbody>

                            <?php foreach ($transacoes as $transacao): ?>

                                <?php
                                    $entrada = $transacao['tipo'] === 'Entrada';
                                ?>

                                <tr>
                                    <td>
                                        <span class="badge <?= $entrada ? 'bg-success' : 'bg-danger' ?>">
                                            <?= $transacao['tipo'] ?>
                                        </span>
                                    </td>

                                    <td class="<?= $entrada ? 'text-success' : 'text-danger' ?>">
                                        <strong>
                                            R$
                                            <?= number_format($transacao['valor'], 2, ',', '.') ?>
                                        </strong>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($transacao['descricao']) ?>
                                    </td>

                                    <td>
                                        <?= $transacao['data'] ?>
                                    </td>
                                </tr>

                            <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

</body>
</html>