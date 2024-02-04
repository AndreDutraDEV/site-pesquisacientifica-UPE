<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $data = array(
        'coluna1' => $_POST['coluna1'],
        'coluna2' => $_POST['coluna2'],
    );

    $tableName = 'nome_da_tabela';

    $result = cAjax::insertDadosFromTable($data, $tableName);

    if ($result['status'] === 'success') {
        echo 'Inserção bem-sucedida!';
    } else {
        echo 'Erro durante a inserção: ' . $result['response'];
    }
} else {
    header('Location: formulario.html');
    exit();
}
?>