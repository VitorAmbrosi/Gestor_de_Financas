<?php

require('carregar_twig.php');
require('carregar_pdo.php');

$mes = isset($_GET['mes']) ? (int)$_GET['mes'] : (int)date('m');
$ano = isset($_GET['ano']) ? (int)$_GET['ano'] : (int)date('Y');

$stmt = $pdo->prepare('
    SELECT * FROM transacoes
    WHERE MONTH(data_transacao) = :mes
      AND YEAR(data_transacao)  = :ano
    ORDER BY data_transacao DESC
');
$stmt->execute([':mes' => $mes, ':ano' => $ano]);
$todasTransacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo $twig->render('transacoes.html', [
    'transacoes'    => $todasTransacoes,
    'mes_atual'     => $mes,
    'ano_atual'     => $ano,
]);