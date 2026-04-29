<?php

require('carregar_twig.php');
require('carregar_pdo.php');

$transacoes = $pdo->query('SELECT * FROM transacoes');
$todasTransacoes = $transacoes->fetchAll(PDO::FETCH_ASSOC);

echo $twig->render('transacoes.html', [
    'transacoes' => $todasTransacoes,
]);