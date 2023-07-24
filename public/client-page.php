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
        <title>Client Management System</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
 
    </head>
    <body>
        <?php include('partials/navbar.php'); ?>   

        <div class="container">
        
        </br>
        
        <h2>Clients</h2>

        <?php 
            $clients = new ClientView;
            $result = $clients->getClients();

            if (empty($result)) {
                echo '<tr><td colspan="3">No clients found.</td></tr>';
            } else { ?>

                <table class="table table-bordered table-striped table-hover" id="clientTable">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Client Code</th>
                        <th scope="col">No. of linked contacts</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($result as $client) {
                                echo '<tr data-client-id=' . $client["id"] . '>';
                                echo '<td>' . $client['name'] . '</td>';
                                echo '<td>' . $client['client_code'] . '</td>';
                                echo '<td>' . $client['num_contacts'] . '</td>';
                                echo '</tr>';
                            }
                            }  
                            
                        ?>
                    </tbody>
                </table>

            </br>
        
            </br>
        
        <h2>Client Contacts</h2>
        <?php
        //Fetch Contact data  
        $clientContacts = new ClientContactView;
        $result = $clientContacts->getClientContacts($client['id']); 

        if (count($result) === 0) {
            echo '<tr><td colspan="3">No client contacts found.</td></tr>';
        } else {?>

            <table class="table table-bordered table-striped" id="clientContactTable">
            <thead>
            <tr>
                <th scope="col">Contact Name</th>
                <th scope="col">Email</th>
                <th scope="col">Unlink</th>
            </tr>
            </thead>
            <tbody>
            <?php
                foreach ($result as $clientcontact) {
                    echo '<tr>';
                    echo '<td>' . $clientcontact['name'] . '</td>';
                    echo '<td>' . $clientcontact['email'] . '</td>';
                    echo '<td>' . "<a href=# onclick=deleteRecord(" . $clientcontact['client_id'] . "," . $clientcontact['contact_id']. ">Unlink</a>";
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
                class="btn btn-light"
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
                data-mdb-target="#contacts"
                type="button"
                role="tab"
                aria-controls="contacts"
                aria-selected="false">
                Contacts
                </button>
            </li>
   
        </ul>

        <div class="tab-content" id="myTabContent0">
            <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab0">
                <!-- CLient Form -->
                <h2>Add Client</h2>
                    
                    <form action="../app/classes/includes/client-inc.php" method="post" onsubmit="return validateClientForm();">
                    <div class="form-group">
                        <label for="clientName">Name</label>
                        <input type="text" class="form-control" name="clientName" id="clientName" placeholder="Enter client name">
                        
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
            </div>
            <div class="tab-pane fade" id="contacts" role="tabpanel" aria-labelledby="contacts-tab0">
            <!-- Link client contact -->    
            <form action="../app/classes/includes/client-contact-inc.php" method="post">
            <div class="form-group">   
                <label for="client">Select a Client:</label>
                <select name="client" id="client" class="form-select form-select-lg">
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
 
         <script>
            // Under construction
            function deleteRecord(clientID, contactID) {
                 
                if (confirm("Are you sure you want to delete this record?")) {
                 
                var xhr = new XMLHttpRequest();

                // Configure the AJAX request
                xhr.open('POST', '../app/classes/includes/client-contact-inc.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                // Send the request with the record ID
                xhr.send('clientId=' + encodeURIComponent(clientId) + '&contactId=' + encodeURIComponent(contactId));

                // Handle the AJAX response
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        
                        console.log(xhr.responseText);
                         
                    } else {
                         
                        console.error('Delete failed: ' + xhr.responseText);
                    }
                    }
                };
                }
            }
        </script>
    </body>
     
</html>