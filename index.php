<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Pesquisa de Artigos | UPE Surubim</title>
    <!-- Importação de estilos -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <header>
        <img src="assets/images/logoUpeSemBack.png" alt="header_logo" class="logo-min">
        <nav>
            <ul class="nav_menu">
                <li><a href="" class="link_nav_menu">Quem Somos?</a></li>
                <li><a href="" class="link_nav_menu">Fale Conosco</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="hero_section">
            <div class="hero_banner">
                <img src="assets/images/capaUPESuru.png" alt="image_UPE" class="back_title_logo">
                <h1>Busca Científica <i>Campus</i> Surubim</h1>
            </div>
            <div class="search_panel">
                <h3>Painel de Buscas</h3>
                <div class="search_builder_area">
                    <form action="" class="search_form">

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
                                        <option value="teste">Teste 1</option>
                                        <option value="teste">Teste 2</option>
                                        <option value="teste">Teste 3</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="search_main form_group">
                            <label for="search_bar_main">Faça sua busca aqui:</label>
                            <div class="search_bar">
                                <input type="text" class="form_input" id="search_bar_main" name="search_bar_main"
                                    placeholder="Digite a busca...">
                                <button type="submit" class="search_button_bar"><img src="assets/icons/search-sharp.svg"
                                        alt="Buscar"></button>
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
                    <h3>Recentemente adicionados:</h3>
                </div>

                <button class="navigation_carrousel_btn left_btn" onclick="slideCarousel('showcase-1', 'l')"><img
                        src="assets/icons/chevron-back.svg" alt=""></button>
                <button class="navigation_carrousel_btn right_btn" onclick="slideCarousel('showcase-1', 'r')"><img
                        src="assets/icons/chevron-forward.svg" alt=""></button>

                <div class="carousel_items">

                    <div class="list_items">
                        <div class="item_showcase">
                            <div class="img_content_item_list">
                                <img src="assets/images/imagem-capa-upe.png" alt="" class="img_item_list">
                            </div>
                            <div class="body_content_item_list">
                                <h4 class="title_item_list">Titulo fictício aqui</h4>
                                <p class="min_description_item_list"><span class="detail_text">Decrição: </span>Lorem
                                    ipsum dolor sit amet consectetur adipisicing
                                    elit. Minus ipsam, ipsum recusandae unde vitae doloremque, temporibus debitis magnam
                                    molestias voluptas beatae explicabo commodi neque quidem velit amet sit porro
                                    facere.</p>
                                <button class="view_item_btn">Ver Artigo</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </section>
    </main>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="assets/js/main.js"></script>

</body>

</html>