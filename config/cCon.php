<?php
/*
    ***********************************************
    CONNECTION.PHP - PARAMETRIZAÇÃO DA CONEXÃO COM BANCO DE DADOS DE NOSSA APLICAÇÃO.
    ***********************************************
    Copyright (c) 2020, Jeferson Souza INTERLIG SOLUÇÕES INTELIGENTES
*/
abstract class Conn
{
    //    // LOCAL
    const host = 'localhost';
    const dbname = 'upe_article_database';
    const user = 'root';
    const password = '';

    static function conectar()
    {
        try {
            $pdo = new PDO(
                'mysql:host=' .
                    self::host .
                    ';dbname=' .
                    self::dbname .
                    ';charset=utf8',
                self::user,
                self::password
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
}
