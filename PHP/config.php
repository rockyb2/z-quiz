<?php 
    // defiistion des constante d'information pour l connexion
const MYSQL_HOST = 'localhost';

const MYSQL_PORT = 3307;
const MYSQL_NAME = 'z_quiz';
const MYSQL_USER = 'root';
const MYSQL_PASSWORD = '';



try{

    // création de l'instance PDO

    $connexionDB = new PDO(
        sprintf('mysql:host=%s;dbname=%s;port=%s', MYSQL_HOST, MYSQL_NAME, MYSQL_PORT),
        MYSQL_USER,
        MYSQL_PASSWORD
    );

    $connexionDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(Exception $exception) {
    die('Erreur: '.$exception->getMessage());
}



