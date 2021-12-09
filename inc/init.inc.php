<?php
$bdd = new PDO('mysql:host=localhost;dbname=Veville', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
]);

$tabIdArticle = [];

session_start();

define("RACINE_SITE", $_SERVER['DOCUMENT_ROOT'] . '/PHP/12-TP-VEVILLE/');


define("URL", "http://localhost/PHP/12-TP-VEVILLE/");




require_once 'fonctions.inc.php';

