<?php

require '../config/cAjax.php';

$id = $_GET['id'];
if ($id) {
    $get_article = cAjax::getDadosFromTablesParametro('articles', 'article_id', $id);
}

$nameCategory = cAjax::getDadosFromTablesParametro('category', 'category_id', $get_article[0]['category_id'])[0]["name"];


function base64ParaUrlImg($base64_string) {
    $info = getimagesizefromstring(base64_decode($base64_string));
    $mime_type = $info['mime'];

    $base64_com_extensao = "data:{$mime_type};base64,{$base64_string}";

    return $base64_com_extensao;
}

$image_article = base64ParaUrlImg($get_article[0]["img_preview"]);

function base64ParaUrlPdf($base64_string, $filename = "documento.pdf") {

    $mime_type = 'application/pdf';

    $base64_com_extensao = "data:{$mime_type};base64," . $base64_string;

    // $download_link = "<a href=\"$base64_com_extensao\" download=\"$filename\">Download do PDF</a>";

    return $base64_com_extensao;
}

$pdf_article = base64ParaUrlPdf($get_article[0]["pdf"]);

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
    <header>
        <img src="../assets/images/logoUpeSemBack.png" alt="header_logo" class="logo-min">
        <nav>
            <ul class="nav_menu">
                <li><a href="" class="link_nav_menu">Quem Somos?</a></li>
                <li><a href="" class="link_nav_menu">Fale Conosco</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="view_article_section">
            <h3>Visualizando Artigo</h3>
            <div class="view_article">
                <div class="cover_article">
                    <img src="<?php echo $image_article;?>" alt="" class="img_cover">
                </div>
                <div class="description_article_info">

                    <h4><span class="detail_text">Título: </span><?php echo $get_article[0]["title"] ?></h4>
                    <h4><span class="detail_text">Autores: </span><?php echo implode(', ', json_decode($get_article[0]["autors"], true)) ?></h4>
                    <h4><span class="detail_text">Categoria: </span><?php echo $nameCategory ?></h4>
                    <h4><span class="detail_text">Data de postagem: </span><?php echo date("d/m/Y", strtotime($get_article[0]["date_post"])); ?></h4>
                    <div class="text_description">
                        <h4><span class="detail_text">Descrição: </span></h4>
                        <p><?php echo $get_article[0]["resume"] ?></p>
                    </div>
                    <a href="<?php echo $pdf_article?>"><button class="view_item_btn">Abrir Artigo</button></a>
                </div>
            </div>
        </section>
    </main>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="../assets/js/main.js"></script>

</body>

</html>