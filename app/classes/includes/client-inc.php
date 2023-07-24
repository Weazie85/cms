<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //get form data
    $name = filter_var($_POST["clientName"], FILTER_SANITIZE_STRING);
     
    //instatiate controller 
    include "../dbh.php";
    include "../models/client.php";
    include "../controllers/client-contr.php";

    $client = new ClientContr($name);

    //Error handling
    $client->addClient();

    //Client page
    header("location: ../../../public/client-page.php?error=none");
}
