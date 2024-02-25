<?php
require_once '../config/cGeral.php';
require '../config/cAjax.php';
$all_data = cAjax::getDadosFromTables('articles');
$all_data_category = cAjax::getDadosFromTables('category');

$textSearch = ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search_bar_main"])) ? $_POST["search_bar_main"] : array();

$responseSearch = cAjax::getSearch('articles', 'title', $textSearch);

$textSearch = @$_POST['search_bar_main'];

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
        <section class="hero_section">
            <div class="search_panel">
                <h3>Painel de Buscas</h3>
                <div class="search_builder_area">
                <form action="search.php" class="search_form" method="POST">

                        <div class="search_filters">

                            <h4>Filtros de Pesquisa:</h4>

                            <div class="grid_filters">
                                <div class="form_group">
                                    <label for="date_filter">Data máxima:</label>
                                    <input type="date" name="date_filter" id="date_filter" class="form_input">
                                </div>

                                <div class="form_group">
                                    <label for="categ_filter">Categoria:</label>
                                    <select type="date" name="categ_filter" id="categ_filter" class="form_input">
                                        <?php
                                        if (count($all_data_category) > 0) {
                                            foreach ($all_data_category as $key => $value) {
                                                echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="search_main form_group">
                            <label for="search_bar_main">Faça sua busca aqui:</label>
                            <div class="search_bar">
                                <input type="text" class="form_input" id="search_bar_main" name="search_bar_main" placeholder="Digite a busca..." value="<?php echo $textSearch; ?>">
                                <button type="submit" class="search_button_bar"><img src="../assets/icons/search-sharp.svg" alt="Buscar"></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <section class="showcase_section">

            <div class="rolling_showcase" id="showcase-1">

                <div class="headers_showcases">
                    <span class="divider_sections"></span>
                    <h3>Resultados da Busca:</h3>
                </div>


                <div class="carousel_items">
                    <button class="navigation_carrousel_btn left_btn" onclick="slideCarousel('showcase-1', 'l')"><img src="../assets/icons/chevron-back.svg" alt=""></button>
                    <button class="navigation_carrousel_btn right_btn" onclick="slideCarousel('showcase-1', 'r')"><img src="../assets/icons/chevron-forward.svg" alt=""></button>
                    <div class="list_items">
                        <?php
                        if (count($responseSearch) > 0) {
                            foreach ($responseSearch as $data_article) {
                                $nameCategory = cAjax::getDadosFromTablesParametro('category', 'category_id', $data_article['category_id'])[0]["name"];
                                $img_preview_base64 = base64_encode($data_article["authors_img"]);
                                $img_preview_uri = "data:image/png;base64," . $img_preview_base64;
                                ?>
                                <div class="item_showcase">
                                    <div class="img_content_item_list">
                                        <img src="<?php echo $img_preview_uri; ?>" alt="Capa do artigo" class="img_item_list">
                                    </div>
                                    <div class="body_content_item_list">
                                        <h4 class="title_item_list"><?php echo $data_article['title'] ?></h4>
                                        <p><span class="detail_text">Categoria: </span><?php echo $nameCategory ?></h4>
                                        <p class="min_description_item_list"><span class="detail_text">Resumo: </span><?php echo $data_article['resume'] ?></p>
                                        <a href="/site-pesquisacientifica-UPE/pages/viewArticle.php?id=<?php echo $data_article['article_id'] ?>"><button class="btn_primary">Ver Artigo</button></a>
                                    </div>
                                </div>

                        <?php
                            }
                        } else {
                            echo '<h2 style="color: #fff" >Nennhum artigo encontrado!</h2>';
                        } ?>
                    </div>
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