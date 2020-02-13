<?php

//definition des regex pour la validation du formulaire
define('REGEX_APPOINTMENTDATE', '/^(19|20)[0-9]{2}-[0-9]{2}-[0-9]{2}$/');
define('REGEX_APPOINTMENTTIME', '/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/');
define('REGEX_MAIL', '/^[a-zA-Z0-9\._-]+@[a-zA-Z0-9\._-]{2,}\.[a-z]{2,4}$/');

// Initialisation du tableau des erreurs dans la classe Patients
// Gestion d'erreur générale d'envoi du formulaire
if (isset($_POST['submit'])) {

// création des instances de classe
    $patient = new Patient();
    $appointment = new Appointment();

// récupération des données du formulaire
    $appointmentDate = isset($_POST['appointmentDate']) ? htmlspecialchars($_POST['appointmentDate']) : '';
    $appointmentTime = isset($_POST['appointmentTime']) ? htmlspecialchars($_POST['appointmentTime']) : '';
    $patient->mail = isset($_POST['mail']) ? htmlspecialchars($_POST['mail']) : '';

// validation de la date du rendez-vous
    if (empty($appointmentDate)) {
        $appointment->formErrors['appointmentDate'] = 'Ce champ est vide';
    } elseif (!preg_match(REGEX_APPOINTMENTDATE, $appointmentDate)) {
        $appointment->formErrors['appointmentDate'] = 'Ce champ n\'est pas valide';
    } elseif (strtotime($appointmentDate) < time()) {
        $appointment->formErrors['appointmentDate'] = 'veuillez entrer une date postérieure à la date du jour';
    }

// validation de l'heure du rendez-vous
    if (empty($appointmentTime)) {
        $appointment->formErrors['appointmentTime'] = 'Ce champ est vide';
    } elseif (!preg_match(REGEX_APPOINTMENTTIME, $appointmentTime)) {
        $appointment->formErrors['appointmentTime'] = 'Ce champ n\'est pas valide';
    }
    
// concatenation de la date et l'heure
        $appointment->dateHour = $appointmentDate . ' ' . $appointmentTime;

 // vérification de la disponibilité du créneau horaire
    if (!$appointment->hasUniqueTimeSlot()){
        $appointment->formErrors['appointmentTime'] = 'Ce créneau horaire est indisponible, veuillez en choisir un autre';
        $appointment->formErrors['appointmentDate'] = 'Ce créneau horaire est indisponible, veuillez en choisir un autre';
    }
    
// validation de l'adresse mail
    if (empty($patient->mail)) {
        $patient->formErrors['mail'] = 'Ce champ est vide';
    } elseif (!preg_match(REGEX_MAIL, $patient->mail)) {
        $patient->formErrors['mail'] = 'Ce champ n\'est pas valide';
    } elseif(!is_object($patient->getPatientByMail())){
        $patient->formErrors['mail'] = 'L\'adresse e-mail n\'existe pas, le patient doit etre enregistré';
    }

// vérification que tous les champs sont prêts à etre envoyés 
    if (empty($appointment->formErrors) && empty($patient->formErrors)) {


// association d'un id grace au mail renseigné
        $appointment->idPatients = $patient->getPatientIdByMail()->id;

// insertion des données
        $success = $appointment->addAppointment();

// création d'un message de confirmation de création de rendez-vous
        if ($success){
        $_SESSION['appointmentCreated'] = 'Le rendez vous a été créé avec succès';
        header('location: /partie2/views/exo6_getAppointmentList.php');
        exit();
        }
    }
}
?>