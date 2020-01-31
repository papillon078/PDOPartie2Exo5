<?php
require_once '../models/database.php';
require_once '../models/client.php';
require_once '../controllers/exo1_getClientListController.php';
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="../assets/libraries/bootswatch/superhero/bootstrap.min.css" />
        <link rel="stylesheet" href="../assets/css/style.css" />
        <title>PDO-P1-Ex1</title>
    </head>
    <body>
        <?php include '../header.html'; ?>
        <div class="container">
            <h1 class="text-center my-5">1er Exercice : Affichage de la liste des clients</h1>

            <div class="row">
                <div class="col-6">
                    <h2 class="pb-4">Affichage du tableau contenant un objet renvoyé par le fetchall</h2>
                    <pre class="border border-white p-3">
                        <?= var_dump($clientList); ?>
                    </pre>

                </div>
                <div class="col-6">
                    <h2>affichage d'une ligne</h2>
                    <p>nom de famille du 1er de la liste : <?= $clientList[0]->lastName ?></p>
                    <h2>Affichage de la liste complete</h2>
                    <ol class="p-5">
                        <?php
                        //chaque ligne du tableau resultat contient un objet dont les attributs 
                        //correspondent aus colonnes de ma table
                        foreach ($clientList as $item) {
                            ?>
                                <li>
                                    <div class="alert alert-info w-75 font-weight-bolder text-center text-uppercase" role="alert"><?= $item->lastName . ' ' . $item->firstName ?></div>
                                </li>
                        <?php } ?>
                    </ol>
                    <img src="../assets/img/codeworks.jpg" alt="seal"/>

                </div>

            </div>
        </div>
        <script src="../assets/libraries/jquery/jquery-3.4.1.min.js"></script>
        <script src="../assets/libraries/bootstrap-4.3.1-dist/js/bootstrap.min.js" rel="stylesheet"></script>
        <script src="../assets/js/script.js"></script>
    </body>
</html>

