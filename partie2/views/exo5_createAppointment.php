<?php
session_start();
include '../init/function.php';
require_once '../models/database.php';
require_once '../models/patient.php';
require_once '../models/appointment.php';
require_once '../controllers/exo5_createAppointmentController.php';
?>
<!doctype html>
<html lang=fr dir="ltr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="/partie2/assets/libraries/bootstrap-4.3.1-dist/css/bootstrap.min.css" />
        <link href="/partie2/assets/css/style.css" rel="stylesheet" />
        <title>PDO P2 exo5</title>
    </head>
    <body class="lightBody">
        <img class="seal" src="../assets/img/banExo1.jpg" alt="seal"/>
        <?php include '../header.html'; ?>
        <div class="container">
            <section class"lightBody">
                     <div class="my-5">
                    <h1>Prise de Rendez-vous</h1>
                    <p>Pour notre ami il est deja trop tard, ne laissez pas passer votre chance, prenez un rendez-vous !</p>
                    <!-- Début du formulaire d'inscription-->
                    <form action="#" method="POST" class="was-invalidated">
                        <div class="row">
                            <!-- 1ere section-->
                            <fieldset class="border py-2 col-6">
                                <!-- Champ date du rendez-vous-->
                                <label for="appointmentDate">Date du rendez-vous</label>
                                <input type="date" name="appointmentDate" class="<?= !isset($_POST['submit']) ? '' : (empty($appointment->formErrors['appointmentDate']) ? 'is-valid' : 'is-invalid') ?> form-control " 
                                       id="appointmentDate" />
                                <div class="<?= empty($appointment->formErrors['appointmentDate']) ? 'valid-feedback' : 'invalid-feedback' ?>">
                                    <?= isset($appointment->formErrors['appointmentDate']) ? $appointment->formErrors['appointmentDate'] : 'champ correct' ?>
                                </div>
                                <!-- Champ heure du rendez-vous-->
                                <label for="appointmentTime">Heure du rendez-vous</label>
                                <input type="time" name="appointmentTime" class="<?= !isset($_POST['submit']) ? '' : (empty($appointment->formErrors['appointmentTime']) ? 'is-valid' : 'is-invalid') ?> form-control " 
                                       id="appointmentTime" />
                                <div class="<?= empty($appointment->formErrors['appointmentTime']) ? 'valid-feedback' : 'invalid-feedback' ?>">
                                    <?= isset($appointment->formErrors['appointmentTime']) ? $appointment->formErrors['appointmentTime'] : 'champ correct' ?>
                                </div>
                                <!-- Champ email-->
                                <label for="mail">votre adresse mail</label>
                                <input type="email" name="mail" class="<?= !isset($_POST['submit']) ? '' : (empty($patient->formErrors['mail']) ? 'is-valid' : 'is-invalid') ?> form-control " 
                                       id="email" placeholder="ex: Jean.Dupont@gmail.com" value="<?= isset($patient->mail) ? $patient->mail : '' ?>" />
                                <div class="<?= empty($patient->formErrors['mail']) ? 'valid-feedback' : 'invalid-feedback' ?>">
                                    <?= isset($patient->formErrors['mail']) ? $patient->formErrors['mail'] : 'champ correct' ?>
                                </div>
                            </fieldset>
                        </div><!-- fin row-->
                        
                            <input type="submit" name="submit" value="Envoyer" class="btn btn-success submit my-2 col-6" />
                        
                    </form>
                </div>
            </section>
        </div>
        <?php include '../footer.html'; ?>
        <script src="/partie2/assets/libraries/jquery/jquery-3.4.1.min.js"></script>
        <script src="/partie2/assets/libraries/bootstrap-4.3.1-dist/js/bootstrap.min.js" rel="stylesheet"></script>
        <script src="/partie2/assets/js/script.js"></script>
    </body>
</html>
