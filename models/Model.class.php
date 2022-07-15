<?php

abstract class Model{
    private static $pdo;

// Singleton a faire pour avoir une seul connexion a la base de données
    private static function setBdd(){
        self::$pdo = new PDO("mysql:host=localhost;dbname=vetomoney_2022;charset=utf8", "root", "root");
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function getBdd(){
        if(self::$pdo === null){
            self::setBdd();
        }
        return self::$pdo;
    }
}