<?php

/*
    ***********************************************
    CONFIG.PHP - PARAMETRIZAÇÃO DE NOSSA APLICAÇÃO.
    ***********************************************
    Copyright (c) 2020, Jeferson Souza MESTRES DO PHP
*/
//Iniciando a Sessão em Toda Nossa Aplicação
session_start();

//Configurando o Timezone e a Data Hora do Nosso Servidor
date_default_timezone_set('America/Sao_paulo');

//Configurações da Base de Dados
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DB', 'backend');
define('BASE_URL', 'http://localhost/site-pesquisacientifica-UPE/pages');

//Chamada da Conexão
require 'cCon.php';
$pdo = Conn::conectar();

/* Configurações de Níveis de Acesso */
define('LEVEL_USER', 8); //Nível de Acesso Para Usuários [Operacionais]
define('LEVEL_SUPER', 10); //Nível de Acesso Para Profissional Web [Você]

/*Configurações de Módulos*/
define('MINUTOS_BLOQUEIO', 1); // Constante com a quantidade minutos para bloqueio
define('TENTATIVAS_ACEITAS', 5); //Quantas Tentativas Usuário Pode Fazer Antes de Bloquear
define('REMEMBER', 1); //Lembrar Senha
define('TITLE_LOGIN', 'Login Auth 2.0'); //Nome da Aplicação
define('LOGINACTIVE', 1); //Login Ativo - Módulo Possibilita Acesso Direto, Se Houver Cookies. Para Funcionar Precisa do Remember Ativo.
define('LOGCREATE', 1); //Cria Log com .txt de Login (NOT APPLICATED)
define('LOGINHISTORY', 1); //Cria Histórico de Login - Salve no Banco de Dados. (NOT APPLICATED)

function logout(){
    session_destroy();
    unset($_SESSION['user_level']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_id']);
    unset($_SESSION['user_token']);
    unset($_SESSION['logged']);
    header('Location:  '.BASE_URL.'/home.php');
}