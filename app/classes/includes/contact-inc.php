<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //get form data
    $name = filter_var($_POST["contactName"], FILTER_SANITIZE_STRING);
    $surname = filter_var($_POST["contactSurname"], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST["contactEmail"], FILTER_SANITIZE_EMAIL);

    //instatiate controller 
    include "../dbh.php";
    include "../models/contact.php";
    include "../controllers/contact-contr.php";

    $contact = new ContactContr($name, $surname, $email); 

    //Error handling
    $contact->addContact();

    //Client page
    header("location: ../../../public/contact-page.php?error=none");
}