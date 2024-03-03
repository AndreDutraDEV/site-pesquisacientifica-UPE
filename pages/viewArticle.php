<?php
require_once '../config/cGeral.php';
require '../config/cAjax.php';

$id = @$_GET['id'];
if ($id) {
    $get_article = cAjax::getDadosFromTablesParametro('articles', 'article_id', $id);
} else {
    exit;
}

$nameCategory = cAjax::getDadosFromTablesParametro('category', 'category_id', $get_article[0]['category_id'])[0]["name"];

function base64ParaUrlImg($base64_string)
{
    $info = getimagesizefromstring(base64_decode($base64_string));
    $mime_type = $info['mime'];

    $base64_com_extensao = "data:{$mime_type};base64,{$base64_string}";

    return $base64_com_extensao;
}

$img_group_base64 = base64_encode($get_article[0]["authors_img"]);
$img_group_uri = "data:image/png;base64," . $img_group_base64;

$pdf_article = "data:application/pdf;base64," . base64_encode($get_article[0]["pdf"]);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Pesquisa de Artigos | UPE Surubim</title>
    <!-- Importação de estilos -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php
    include('../includes/header.php');
    ?>
    <main>
        <section class="view_article_section">
            <h3>Visualizando Artigo</h3>
            <div class="view_article">
                <div class="cover_article">
                    <embed src="<?php echo $pdf_article; ?>" type="application/pdf" width="100%" height="650px">
                </div>
                <div class="description_article_info">
                    <h4><span class="detail_text">Título: </span><?php echo $get_article[0]["title"] ?></h4>
                    <h4><span class="detail_text">Autores: </span><?php if (strpos(json_decode($get_article[0]["authors"], true), ",") !== false){ echo implode(', ', json_decode($get_article[0]["authors"], true));} else {echo $get_article[0]["authors"];} ?></h4>
                    <h4><span class="detail_text">Categoria: </span><?php echo $nameCategory ?></h4>
                    <h4><span class="detail_text">Data de postagem: </span><?php echo date("d/m/Y", strtotime($get_article[0]["date_post"])); ?></h4>
                    <div class="text_description">
                        <h4><span class="detail_text">Resumo: </span></h4>
                        <p><?php echo $get_article[0]["resume"] ?></p>
                    </div>
                    <a href="<?php echo $pdf_article; ?>" download="artigo.pdf"><button class="btn_primary">Baixar Artigo</button></a>
                    <div class="img_group_box">
                        <h3>Grupo autor do artigo:</h3>
                        <img class="view_img_group" src="<?php echo $img_group_uri; ?>" alt="Imagem do Grupo">
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include('../includes/footer.php') ?>
    <script src="../assets/js/main.js"></script>

    <script>
        function openPDF(pdfUrl) {
            window.open(pdfUrl, '_blank');
            setTimeout(function() {
                location.reload();
            }, 1000);
        }
    </script>
</body>

</html>