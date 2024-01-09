<?php
//Verifica Existência das Sessões
require_once '../config/cGeral.php';
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
    header('Location: ../index.php');
}

if ($_SESSION['user_level'] < LEVEL_SUPER) {
    header('Location: ../index.php');
}

?>

<?php
$action = strip_tags(
    filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRIPPED)
);
if ($action == 'logout') {
    logout();
}
?>
<h3>ola admin</h3>
<a href="?action=logout" class="nav__link"> 
    <span class="material-icons-outlined">user_logout</span> Sair
</a>