<?php
require_once '../config/cGeral.php';
require '../config/cAjax.php';

if (isset($_SESSION['logged']) && $_SESSION['logged']) {
    header('Location: adminPage.php');
}

$pIndex = 'login';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>
    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tela de login</title>
        <link rel="stylesheet" href="../assets/css/alerts.css">
        <link rel="stylesheet" href="../assets/css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>

    <body>
        <?php
        include('../includes/header.php');
        ?>
        <div class="continer_floating_box">
            <div class="login_box">
                <h2>Login</h2>
                <form id="<?php echo $pIndex; ?>Form" method="POST">
                    <div class="form_group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form_input" placeholder="Digite seu email">
                    </div>
                    <div class="form_group">
                        <label for="pasword">Senha</label>
                        <input type="password" name="user_senha" class="form_input" placeholder="Digite sua senha">
                    </div>
                    <input type="hidden" name="user_login" value="true">
                    <button type="submit" class="btn_primary btn" id="<?php echo $pIndex; ?>Btn">Entrar</button>
                </form>
            </div>
        </div>

        <div id="<?php echo $pIndex; ?>Result"></div>
        <?php include('../includes/footer.php') ?>

        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $(function() {
                var t = !1;
                $("#<?php echo $pIndex; ?>Form").submit(function() {
                    var e = $(this),
                        n = $("#<?php echo $pIndex; ?>Form #<?php echo $pIndex; ?>Btn"),
                        o = n.val(),
                        a = new FormData(this);

                    function r() {
                        n.removeAttr("disabled"), n.val(o), (t = !1);
                    }
                    return (
                        t ||
                        $.ajax({
                            beforeSend: function() {
                                (t = !0), n.attr("disabled", !0), n.val("Entrando..."), $(".error").remove();
                            },
                            url: e.attr("action"),
                            type: e.attr("method"),
                            data: a,
                            processData: !1,
                            cache: !1,
                            contentType: !1,
                            success: function(t) {
                                r(), "OK" == t ? alert("Dados enviados com sucesso") : $("#<?php echo $pIndex; ?>Result").html(t);
                            },
                            error: function(t, e, n) {
                                r(), alert(t.responseText);
                            },
                        }),
                        !1
                    );
                });
            });
        </script>
    </body>
    </html>

    <?php

} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['user_login']) {

        $user_email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $user_senha = filter_var($_POST['user_senha'], FILTER_DEFAULT);

        // Dica 4 - Verifica se o usuário já excedeu a quantidade de tentativas erradas do dia
        $sql =
            'SELECT count(*) AS tentativas, MINUTE(TIMEDIFF(NOW(), MAX(data_hora))) AS minutos ';
        $sql .=
            "FROM tab_log_tentativa WHERE ip = ? and DATE_FORMAT(data_hora,'%Y-%m-%d') = ? AND bloqueado = ?";
        $stm = $pdo->prepare($sql);
        $stm->bindValue(1, $_SERVER['SERVER_ADDR']);
        $stm->bindValue(2, date('Y-m-d'));
        $stm->bindValue(3, 'SIM');
        $stm->execute();
        $retorno = $stm->fetch(PDO::FETCH_OBJ);

        if (
            !empty($retorno->tentativas) &&
            intval($retorno->minutos) <= MINUTOS_BLOQUEIO
        ) :
            $message = [
                'status' => 'error',
                'message' =>
                'Você excedeu o limite de ' .
                    TENTATIVAS_ACEITAS .
                    ' tentativas, login bloqueado por ' .
                    MINUTOS_BLOQUEIO .
                    ' minutos!',
                'redirect' => '',
            ];
    ?>
            <script>
                // Adiciona a mensagem de status
                $("#<?php echo $pIndex ?>Result").html('<div class="status-top-right text-center" id="status-container"><div class="status status-' + '<?php echo $message['status'] ?>' + '"><div class="status-message"><span class="fa fa-check-circle"></span>' + '<?php echo $message['message'] ?>' + '</div></div></div>');

                // Esconde a mensagem após 2 segundos
                setTimeout(() => {
                    $("#<?php echo $pIndex ?>Result").html('');
                }, 2000);
            </script>

            <?php
            return;
        endif;

        // Dica 5 - Válida os dados do usuário com o banco de dados
        $sql = 'SELECT * FROM users WHERE user_email = ?  LIMIT 1';
        $stm = $pdo->prepare($sql);
        $stm->bindValue(1, $user_email);
        // $stm->bindValue(2, );
        $stm->execute();
        $retorno = $stm->fetch(PDO::FETCH_OBJ);

        // Dica 6 - Válida a senha utlizando a API Password Hash
        if (
            !empty($retorno) && password_verify($user_senha, $retorno->user_password)
        ) :
            //CRIA AS SESSÕES DE ACESSO
            $_SESSION['user_id'] = $retorno->user_id;
            $_SESSION['user_turma_id'] = $retorno->user_turma_id;
            $_SESSION['user_email'] = $retorno->user_email;
            $_SESSION['user_level'] = $retorno->user_level;
            $_SESSION['user_token'] = $retorno->user_token;
            $_SESSION['tentativas'] = 0;
            $_SESSION['logged'] = 1;

        // Dica 7 - Grava a tentativa independente de falha ou não
        else :
            $_SESSION['logged'] = 0;
            $_SESSION['tentativas'] = isset($_SESSION['tentativas'])
                ? ($_SESSION['tentativas'] += 1)
                : 1;
            $bloqueado = $_SESSION['tentativas'] == TENTATIVAS_ACEITAS ? 'SIM' : 'NAO';

            $sql =
                'INSERT INTO tab_log_tentativa (ip, email, origem, bloqueado) VALUES (:ip, :email, :origem, :bloqueado)';
            $stm = $pdo->prepare($sql);
            $stm->bindValue(':ip', $_SERVER['SERVER_ADDR']);
            $stm->bindValue(':email', $user_email);
            $stm->bindValue('origem', $_SERVER['HTTP_REFERER']);
            $stm->bindValue('bloqueado', $bloqueado);
            $stm->execute();
        endif;
        // Se logado envia código 1, senão retorna mensagem de erro para o login
        if ($_SESSION['logged'] == 1) :
            if ($retorno->user_level >=  LEVEL_SUPER) {
                $message = [
                    'status' => 'success',
                    'message' => 'Login realizado com sucesso aguarde...',
                    'redirect' => 'adminPage.php',
                    // 'redirect' => 'web/welcomeAdmin.php',
                ];
            ?>
                <script>
                    // Adiciona a mensagem de status
                    $("#<?php echo $pIndex ?>Result").html('<div class="status-top-right text-center" id="status-container"><div class="status status-' + '<?php echo $message['status'] ?>' + '"><div class="status-message"><span class="fa fa-check-circle"></span>' + '<?php echo $message['message'] ?>' + '</div></div></div>');

                    // Esconde a mensagem após 2 segundos
                    setTimeout(() => {
                        $("#<?php echo $pIndex ?>Result").html('');
                        window.location.href = '<?php echo $message['redirect']; ?>';

                    }, 2000);
                </script>

            <?php
            } else {
                $message = [
                    'status' => 'success',
                    'message' => 'Login realizado com sucesso aguarde...',
                    'redirect' => 'web/welcomeUser.php',
                ];
            ?>
                <script>
                    // Adiciona a mensagem de status
                    $("#<?php echo $pIndex ?>Result").html('<div class="status-top-right text-center" id="status-container"><div class="status status-' + '<?php echo $message['status'] ?>' + '"><div class="status-message"><span class="fa fa-check-circle"></span>' + '<?php echo $message['message'] ?>' + '</div></div></div>');

                    // Esconde a mensagem após 2 segundos
                    setTimeout(() => {
                        $("#<?php echo $pIndex ?>Result").html('');
                        window.location.href = '<?php echo $message['redirect']; ?>';

                    }, 2000);
                </script>

            <?php
            }
        else :
            if ($_SESSION['tentativas'] == TENTATIVAS_ACEITAS) :
                $message = [
                    'status' => 'error',
                    'message' =>
                    'Você excedeu o limite de ' .
                        TENTATIVAS_ACEITAS .
                        ' tentativas, login bloqueado por ' .
                        MINUTOS_BLOQUEIO .
                        ' minutos!',
                    'redirect' => '',
                ];
            ?>
                <script>
                    // Adiciona a mensagem de status
                    $("#<?php echo $pIndex ?>Result").html('<div class="status-top-right text-center" id="status-container"><div class="status status-' + '<?php echo $message['status'] ?>' + '"><div class="status-message"><span class="fa fa-check-circle"></span>' + '<?php echo $message['message'] ?>' + '</div></div></div>');

                    // Esconde a mensagem após 2 segundos
                    setTimeout(() => {
                        $("#<?php echo $pIndex ?>Result").html('');
                    }, 2000);
                </script>

            <?php
                return;
            else :
                $message = [
                    'status' => 'warning',
                    'message' =>
                    'Email ou senha INCORRETOS! ' .
                        (TENTATIVAS_ACEITAS - $_SESSION['tentativas']) .
                        ' tentativa(s) antes do bloqueio!',
                    'redirect' => '',
                ];
            ?>
                <script>
                    $("#<?php echo $pIndex ?>Result").prepend('<div class="status-top-right text-center" id="status-container"><div class="status status-' + '<?php echo $message['status']; ?> ' + '"><div class="status-message"><span class="fa fa-check-circle"></span>' + '<?php echo $message['message'] ?>' + '</div></div></div>');
                    setTimeout(() => {
                        $("#<?php echo $pIndex ?>Result").empty();
                    }, 2000)
                </script>
<?php
                return;
            endif;
        endif;
    }
}
