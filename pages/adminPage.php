<?php

require '../config/cAjax.php';

$all_data_category = cAjax::getDadosFromTables('category');

function base64ParaUrlImg($base64_string)
{
    $info = getimagesizefromstring(base64_decode($base64_string));
    $mime_type = $info['mime'];

    $base64_com_extensao = "data:{$mime_type};base64,{$base64_string}";

    return $base64_com_extensao;
}

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
        <section class="register_article_section">
            <h3>Adicionando Novo Artigo</h3>
            <div class="register_article_container">
                <form action="" class="article_form_reg">
                    <div class="form_group title">
                        <label for="article_title_reg">Título do artigo:</label>
                        <input type="text" id="article_title_reg" name="article_title_reg" class="form_input">
                    </div>
                    <div class="form_group resum">
                        <label for="">Resumo:</label>
                        <textarea name="resume_article_reg" id="resume_article_reg" cols="30" rows="10" class="form_area"></textarea>
                    </div>
                    <div class="form_group authors">
                        <label for="authors_article_reg">Autores:</label>
                        <input type="text" id="authors_article_reg" name="authors_article_reg" class="form_input" placeholder="Separe cada nome com uma vígula">
                    </div>
                    <div class="form_group categ">
                        <label for="categ_article_reg">Selecio a categoria que mais se encaixa com o artigo:</label>
                        <select type="date" name="categ_article_reg" id="categ_article_reg" class="form_input">
                            <option value="1">Todas</option>
                            <?php
                            if (count($all_data_category) > 0) {
                                foreach ($all_data_category as $key => $value) {
                                    echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form_group file">
                        <input type="file" class="input_file_article_reg">
                    </div>
                    <button class="btn_primary btn">Cadastrar Artigo</button>
                </form>
            </div>
        </section>
    </main>

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