<?php 
    include "../app/classes/dbh.php";
    include "../app/classes/models/client.php";
    include "../app/classes/views/client-view.php";
    include "../app/classes/models/client-contact.php";
    include "../app/classes/views/client-contact-view.php"; 
    include "../app/classes/models/contact.php";
    include "../app/classes/views/contact-view.php";
     
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Client Management System</title>
         
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <?php include('partials/navbar.php'); ?>
        
        </br>
        
        <div class="container">

        <h2>Contacts</h2>

        <?php
            //retrieve the data from the database
            $contacts = new ContactView;     
            $result = $contacts->getContacts();
         
            if (empty($result)) {
                echo '<tr><td colspan="4">No contacts found.</td></tr>'; 
            } else { ?>

            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Surname</th>
                    <th scope="col">Email</th>
                    <th scope="col">No. of linked clients</th>
                </tr>
                </thead>
                <tbody>
                
                <?php 
                
                    foreach ($result as $contact) {
                        echo '<tr>';
                        echo '<td>' . $contact['name'] . '</td>';
                        echo '<td>' . $contact['surname'] . '</td>';
                        echo '<td>' . $contact['email'] . '</td>';
                        echo '<td>' . $contact['num_clients'] . '</td>';
                        echo '</tr>';
                    }
                }
                ?>
                </tbody>
        </table>

        </br>

        </br>
     
        <ul class="nav nav-tabs mb-3" id="myTab0" role="tablist">
            <li class="nav-item" role="presentation">
                <button
                class="btn btn-light active"
                data-mdb-toggle="tab"
                data-mdb-target="#general"
                type="button"
                role="tab"
                aria-controls="general"
                aria-selected="true">
                General
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                class="btn btn-light"
                data-mdb-toggle="tab"
                data-mdb-target="#clients"
                type="button"
                role="tab"
                aria-controls="clients"
                aria-selected="false">
                Clients
                </button>
            </li>

        </ul>

        <div class="tab-content" id="myTabContent0">
            <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab0">
            
            <h2>Add Contact</h2>

            <form action="../app/classes/includes/contact-inc.php" method="post" onsubmit="return validateContactForm();">
                <div class="form-group">
                    <label for="contactName">Name:</label>
                    <input type="text" class="form-control" name="contactName" id="contactName" placeholder="Enter contact name">
                    <label for="contactSurname">Surname:</label>
                    <input type="text" class="form-control" name="contactSurname" id="contactSurname" placeholder="Enter contact surname">
                    <label for="contactEmail">Email:</label>
                    <input type="text" class="form-control" name="contactEmail" id="contactEmail" placeholder="Enter contact email address">
                    
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>

            </form>

            </div>

            <div class="tab-pane fade" id="clients" role="tabpanel" aria-labelledby="clients-tab0">
                 <!-- Link client contact -->    
            <form action="../app/classes/includes/client-contact-inc.php" method="post">
            <div class="form-group">   
                <label for="client">Select a Client:</label>
                <select name="client" id="client" class="form-select form-select-lg" >
                    <?php 
                        $clients = new ClientView;
                        $result = $clients->getClients();   

                        if (empty($result)) {
                            echo '<option value="1">No client data available</option>';
                        } else {
                            foreach ($result as $client) {
                            echo '<option value=' . $client["id"] . '>' . $client['name'] . '</option>';
                            }
                        } ?>

                </select>

                <br>

                <label for="contact">Select a Contact:</label>
                <select class="form-select form-select-lg" name="contact" id="contact">
                <?php 
                        $contacts = new ContactView;     
                        $result = $contacts->getContacts();
                        
                        if (empty($result)) {
                            echo '<option value="1">No client data available</option>';
                        } else {
                            foreach ($result as $contacts) {
                            echo '<option value=' . $contacts["id"] . '>' . $contacts['name'] . " " . $contacts['surname'] .  '</option>';
                            }
                        } ?>
                </select>

                <br>
                </div>       
                <button type="submit" name="link_contact" class="btn btn-primary">Link Contact</button>
                </form>
            </div>
        
        </div>
  
        </div>
                 
        <script src="scripts/validation.js"></script>
         
        <script src="scripts/tabs.js"></script>             
    </body>

</html>