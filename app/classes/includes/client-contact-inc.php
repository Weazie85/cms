<?php

//instatiate controller 
include "../dbh.php";
include "../models/client-contact.php";
include "../controllers/client-contact-contr.php";

//Link a client to a contact
if (isset($_POST['link_contact'])) {
     
    //get form data
    $clientId = (int)filter_var($_POST["client"], FILTER_SANITIZE_STRING);
    $contactId = (int)filter_var($_POST["contact"], FILTER_SANITIZE_STRING);

    $contact = new ClientContactContr($clientId, $contactId); 

    //Error handling & posting
    $contact->linkClientToContact();

    //Client page
    header("location: ../../../public/client-page.php?error=none");
}

//Unlink a client form a contact
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['link_contact'])) {

    //get form data
    $clientId = (int)filter_var($_POST["clientId"], FILTER_SANITIZE_STRING);
    $contactId = (int)filter_var($_POST["contactId"], FILTER_SANITIZE_STRING);

    $contact = new ClientContactContr($clientId, $contactId); +

    //Error handling & posting
    $contact->unlinkClientFromContact();

    //Client page
    header("location: ../../../public/client-page.php?error=none");
}