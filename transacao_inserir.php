<?php

$erro = false;
$descricao = '';
$valor = '';
$data_transacao = '';
$tipo = '';
$categoria = '';

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

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descricao = $_POST['descricao'] ?? false;
    $valor = $_POST['valor'] ?? false;
    $data_transacao = $_POST['data_transacao'] ?? false;
    $tipo = $_POST['tipo'] ?? false;
    $categoria = $_POST['categoria'] ?? false;

    if (!$descricao || !$valor || !$data_transacao || !$tipo || !$categoria) {
        $erro = 'Preencha todos os campos';
    } else {
        require('carregar_pdo.php');
        $dados = $pdo->prepare('INSERT INTO transacoes (descricao, valor, data_transacao, tipo, categoria) VALUES (?, ?, ?, ?, ?)');

        $dados->bindParam(1, $descricao);
        $dados->bindParam(2, $valor);
        $dados->bindParam(3, $data_transacao);
        $dados->bindParam(4, $tipo);
        $dados->bindParam(5, $categoria);
        $dados->execute();

        header('location:transacao.php');
        die;
    }
}

require('carregar_twig.php');

echo $twig->render('transacao_inserir.html', [
    'erro' => $erro,
    'categorias' => $categorias,
    'categoria_selecionada' => $categoria,
    'descricao' => $descricao,
    'valor' => $valor,
    'data_transacao' => $data_transacao,
    'tipo' => $tipo,
]);
