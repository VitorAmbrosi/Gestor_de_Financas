<?php

require('carregar_pdo.php');
require('carregar_twig.php');

$categorias = [
    'salario' => 'Salário',
    'renda_extra' => 'Renda Extra',
    'freelance' => 'Freelance',
    'investimento' => 'Investimento',
    'resgate' => 'Resgate',
    'alimentacao' => 'Alimentação',
    'moradia' => 'Moradia',
    'transporte' => 'Transporte',
    'saude' => 'Saúde',
    'educacao' => 'Educação',
    'lazer' => 'Lazer',
    'vestuario' => 'Vestuário',
    'contas' => 'Contas e Utilidades',
    'assinaturas' => 'Assinaturas',
    'cartao_credito' => 'Cartão de Crédito',
    'transferencia' => 'Transferência',
    'outros' => 'Outros',
];

$erro = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int) $_POST['id'] : false;
    $descricao = $_POST['descricao'] ?? false;
    $valor = $_POST['valor'] ?? false;
    $data_transacao = $_POST['data_transacao'] ?? false;
    $tipo = $_POST['tipo'] ?? false;
    $categoria = $_POST['categoria'] ?? false;

    if (!$id || !$descricao || !$valor || !$data_transacao || !$tipo || !$categoria) {
        $erro = 'Preencha todos os campos';
    } else {
        $dados = $pdo->prepare('UPDATE transacoes SET descricao = ?, valor = ?, data_transacao = ?, tipo = ?, categoria = ? WHERE id = ?');

        $dados->bindParam(1, $descricao);
        $dados->bindParam(2, $valor);
        $dados->bindParam(3, $data_transacao);
        $dados->bindParam(4, $tipo);
        $dados->bindParam(5, $categoria);
        $dados->bindParam(6, $id);
        $dados->execute();

        header('location:transacao.php');
        die;
    }
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : false;

if (!$id) {
    header('location:transacao.php');
    die;
}

$dados = $pdo->prepare('SELECT * FROM transacoes WHERE id = :id');
$dados->execute([':id' => $id]);

if ($dados->rowCount() != 1) {
    header('location:transacao.php');
    die;
}

$transacao = $dados->fetch(PDO::FETCH_ASSOC);

echo $twig->render('transacao_editar.html', [
    'transacao' => $transacao,
    'categorias' => $categorias,
    'erro' => $erro,
]);