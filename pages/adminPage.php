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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdf_file = $_FILES['file_pdf'];
        $img_file = $_FILES['file_image'];
        
        $pdf_file_content = file_get_contents($pdf_file['tmp_name']);
        $img_file_content = file_get_contents($img_file['tmp_name']);
        
        // Prepare data for insertion
        $data = [
            'title' => $_POST['article_title_reg'],
            'resume' => $_POST['resume_article_reg'],
            'autors' => $_POST['authors_article_reg'],
            'pdf' => $pdf_file_content,
            'img_preview' => $img_file_content,
            'date_post' => "2024-01-14 15:57:33",
            'category_id' => 103,
        ];        

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
        <header>
            <img src="../assets/images/logoUpeSemBack.png" alt="header_logo" class="logo-min">
            <nav>
                <ul class="nav_menu">
                    <li><a href="../index.php" class="link_nav_menu">Home</a></li>
                    <li><a href="" class="link_nav_menu">Quem Somos?</a></li>
                    <li><a href="" class="link_nav_menu">Fale Conosco</a></li>
                </ul>
            </nav>
        </header>
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
                                <option value="1">Nenhuma</option>
                                <?php foreach ($all_data_category as $category) : ?>
                                    <option value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form_group file">
                            <label for="file_pdf">Selecione arquivo do artigo:</label>
                            <input type="file" name="file_pdf" id="file_pdf" class="input_file_article_reg" accept=".pdf" required>
                        </div>
                        <div class="form_group file2">
                            <label for="file_image">Selecione a imagem do grupo:</label>
                            <input type="file" name="file_image" id="file_image" class="input_file_article_reg" accept=".jpg, .png, .jpeg" required>
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


            // $(document).ready(function() {
            //     // Intercepta o envio do formulário
            //     $("#insertArticleForm").submit(function(event) {
            //         event.preventDefault();

            //         var formData = $(this).serialize();

            //         $.ajax({
            //             type: "POST",
            //             url: "adminPage.php",
            //             data: formData,
            //             success: function(response) {
            //                 console.log(response);
            //             },
            //             error: function(error) {
            //                 console.error("Erro na requisição AJAX: " + error.statusText);
            //             }
            //         });
            //     });
            // });
        </script>
    </body>

    </html>
<?php
}
?>