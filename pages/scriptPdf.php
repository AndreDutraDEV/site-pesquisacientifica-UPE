<?php
include 'viewArticle.php';

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="arquivo.pdf"');

// Imprimir o conteúdo binário
echo $pdf_article;
?>
