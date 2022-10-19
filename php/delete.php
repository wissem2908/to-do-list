<?php

include '../config.php';


try {

    //connexion a la base de données
    $bdd = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . "; charset=utf8", DB_USER, DB_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));



    $req = $bdd->prepare('DELETE FROM `todos` WHERE id=?');
    $req->execute(array($_POST['id']));

    echo json_encode("true");
} catch (Exception $e) {
    $msg = $e->getMessage();
    echo json_encode(array("reponse" => "false", "message" => $msg));
}


?>