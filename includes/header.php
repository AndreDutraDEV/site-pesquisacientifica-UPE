<header>
    <img src="assets/images/logoUpeSemBack.png" alt="header_logo" class="logo-min">
    <nav>
        <ul class="nav_menu">
            <li><a href="home.php" class="link_nav_menu">Home</a></li>
            <li><a href="" class="link_nav_menu">Sobre nós</a></li>
            <?php 
            if (isset($_SESSION['logged']) && $_SESSION['logged']) {
                echo "<li><button class='btn_secondary'><a href='?action=logout'>Sair</a></button></li>";
            } else {
                echo "<li><button class='btn_secondary'><a href='login.php'>Entrar</a></button></li>";
            }
            ?>
        </ul>
    </nav>
</header>
<?php
    $action = strip_tags(
        filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRIPPED)
    );
    if ($action == 'logout') {
        logout();
    }
?>