<?php

require_once '../config/cGeral.php';
require '../config/cAjax.php';

if (
    !$_SESSION['user_level'] ||
    !$_SESSION['user_email'] ||
    !$_SESSION['logged'] ||
    !$_SESSION['user_token'] ||
    (!$_SESSION['user_id'] && $_SESSION['blocked'] == 1)
) {
    session_destroy();
    unset($_SESSION['user_level']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_id']);
    unset($_SESSION['user_token']);
    unset($_SESSION['logged']);
    header('Location: login.php');
}

$all_data_category = cAjax::getDadosFromTables('category');

function base64ParaUrlImg($base64_string)
{
    $info = getimagesizefromstring(base64_decode($base64_string));
    $mime_type = $info['mime'];

    $base64_com_extensao = "data:{$mime_type};base64,{$base64_string}";

    return $base64_com_extensao;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {

        $pdf_file = $_FILES['file_pdf'];
        $img_file = $_FILES['file_image'];
        $img_file_group = $_FILES['file_image_group'];

        $data = array();

        $data["title"] = isset($_POST['article_title_reg']) ? $_POST['article_title_reg'] : null;
        $data["resume"] = isset($_POST['resume_article_reg']) ? $_POST['resume_article_reg'] : null;
        $data["authors"] = isset($_POST['authors_article_reg']) ? $_POST['authors_article_reg'] : null;
        $data["category_id"] = isset($_POST['categ_article_reg']) ? $_POST['categ_article_reg'] : null;

        // Verifica se os arquivos foram enviados e se têm conteúdo
        $data["pdf"] = is_uploaded_file($pdf_file['tmp_name']) ? file_get_contents($pdf_file['tmp_name']) : null;
        $data["img_preview"] = is_uploaded_file($img_file['tmp_name']) ? file_get_contents($img_file['tmp_name']) : null;
        $data["authors_img"] = is_uploaded_file($img_file_group['tmp_name']) ? file_get_contents($img_file_group['tmp_name']) : null;

        // Obtém a data atual no formato desejado
        $data["date_post"] = date("Y-m-d H:i:s");

        $tableName = 'articles';

        $result = cAjax::insertDadosFromTable($data, $tableName);

        if ($result['status'] === 'success') {
            echo 'Inserção bem-sucedida!';
        } else {
            echo 'Erro durante a inserção: ' . $result['response'];
        }
    } catch (\Throwable $th) {
        echo 'Erro: ' . $th->getMessage();
    }
} else {
?>
    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home | Pesquisa de Artigos | UPE Surubim</title>
        <link rel="stylesheet" href="../assets/css/style.css">
        <script src="../assets/libs/js/jquery-3.5.1.min.js"></script>
        <script src="../assets/js/main.js"></script>
    </head>

    <body>
        <?php
        include('../includes/header.php');
        ?>
        <main>
            <section class="register_article_section">
                <h3>Adicionando Novo Artigo</h3>
                <div class="register_article_container">
                    <form action="adminPage.php" method="post" class="article_form_reg" id="insertArticleForm" enctype="multipart/form-data">
                        <div class="form_group title">
                            <label for="article_title_reg">Título do artigo:</label>
                            <input type="text" id="article_title_reg" name="article_title_reg" class="form_input" required>
                        </div>
                        <div class="form_group resum">
                            <label for="resume_article_reg">Resumo:</label>
                            <textarea name="resume_article_reg" id="resume_article_reg" cols="30" rows="10" class="form_area" required></textarea>
                        </div>
                        <div class="form_group authors">
                            <label for="authors_article_reg">Autores:</label>
                            <input type="text" id="authors_article_reg" name="authors_article_reg" class="form_input" placeholder="Separe cada nome com uma vírgula" required>
                        </div>
                        <div class="form_group categ">
                            <label for="categ_article_reg">Selecione a categoria que mais se encaixa com o artigo:</label>
                            <select name="categ_article_reg" id="categ_article_reg" class="form_input" required>
                                <option value="">Nenhuma</option>
                                <?php
                                foreach ($all_data_category as $category) {
                                    echo "<option value='" . $category['category_id'] . "'>" . $category['name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form_group file">
                            <label for="file_pdf">Selecione arquivo do artigo:</label>
                            <input type="file" name="file_pdf" id="file_pdf" class="input_file_article_reg" accept=".pdf" required>
                        </div>
                        <div class="form_group file2">
                            <label for="file_image">Selecione a imagem de capa:</label>
                            <input type="file" name="file_image" id="file_image" class="input_file_article_reg" accept=".jpg, .png, .jpeg" required>
                        </div>
                        <div class="form_group file3">
                            <label for="file_image_group">Selecione a imagem do grupo:</label>
                            <input type="file" name="file_image_group" id="file_image_group" class="input_file_article_reg" accept=".jpg, .png, .jpeg" required>
                        </div>
                        <button class="btn_primary btn">Cadastrar Artigo</button>
                    </form>
                </div>
            </section>
        </main>
        <script src="../assets/js/main.js"></script>
        <script src="../assets/libs/js/jquery-3.5.1.min.js"></script>

        <script>
            $(document).ready(function() {
                $("#insertArticleForm").submit(function(event) {
                    event.preventDefault();

                    var formData = new FormData($(this)[0]);

                    $.ajax({
                        type: "POST",
                        url: "adminPage.php",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(error) {
                            console.error("Erro na requisição AJAX: " + error.statusText);
                        }
                    });
                });
            });
        </script>
    </body>
    </html>
    <?php
    $action = strip_tags(
        filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRIPPED)
    );
    if ($action == 'logout') {
        logout();
    }
}
?>