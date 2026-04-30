<?php

require('carregar_pdo.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int) $_POST['id'] ?? false;
    if ($id) {
        $excluir = $pdo->prepare('DELETE FROM transacoes WHERE id = :id');
        $excluir->bindParam(':id', $id);
        $excluir->execute();
    }
    header('location:transacao.php');
    die;
}

$id = (int) $_GET['id'] ?? false;

if (!$id) {
    header('location:transacao.php');
    die;
}

require('carregar_twig.php');

$dados = $pdo->prepare('SELECT * FROM transacoes WHERE id = :id');
$dados->execute([':id' => $id]);

if ($dados->rowCount() != 1) {
    header('location:transacao.php');
    die;
}

$transacao = $dados->fetch(PDO::FETCH_ASSOC);

echo $twig->render('transacao_excluir.html', [
    'transacao' => $transacao,
]);