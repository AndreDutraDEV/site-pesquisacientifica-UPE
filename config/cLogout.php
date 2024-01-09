<?php

require_once 'cGeral.php';


$get = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRIPPED);
$get = strip_tags($get);
 
$message = null;

if (!$get || $get == '' || $get == null) {

    $message = [
        'status' => 'warning', 'message' => 'Oops, nenhuma ção pode ser realizada',
        'redirect' => '../web/welcome.php',
    ];
    ?>
      <script>
            // Adiciona a mensagem de status
            $("#<?php echo $pIndex?>Result").html('<div class="status-top-right text-center" id="status-container"><div class="status status-' + '<?php echo $message['status'] ?>' + '"><div class="status-message"><span class="fa fa-check-circle"></span>' + '<?php echo $message['message'] ?>' + '</div></div></div>');

            // Esconde a mensagem após 2 segundos
            setTimeout(() => {
                $("#<?php echo $pIndex?>Result").html(''); 
            }, 2000);
        </script>
    <?php
    return;
} else {
    
    unset($_SESSION['user_name']);
    unset($_SESSION['user_level']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_id']);
    unset($_SESSION['user_token']);
    unset($_SESSION['logged']);

    $_SESSION['logout'] = 1;
    $message = [
        'status' => 'success', 'message' => 'Logout realizado com sucesso',
        'redirect' => '../index.php'
    ];
    ?>
        <script>
            // Adiciona a mensagem de status
            $("#<?php echo $pIndex?>Result").html('<div class="status-top-right text-center" id="status-container"><div class="status status-' + '<?php echo $message['status'] ?>' + '"><div class="status-message"><span class="fa fa-check-circle"></span>' + '<?php echo $message['message'] ?>' + '</div></div></div>');

            // Esconde a mensagem após 2 segundos
            setTimeout(() => {
                $("#<?php echo $pIndex?>Result").html(''); 
            }, 2000);
        </script>
    <?php
    return;
}

// !3 = 0.1.2.3


// !0 = 1
// !0 = 1
// !0 = 1

// !3 = 6


// !(!0 + !0 + !0) = 6




