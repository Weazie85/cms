<?php

class Contact extends Dbh {

    protected function qryContacts() {

        $stmnt = $this->connect()->prepare('CALL get_contacts;');

        if(!$stmnt->execute()) {
            $stmnt = null;
            exit;
        }
 
        $results = $stmnt->fetchAll(PDO::FETCH_ASSOC);

        return $results;

    }

    protected function setContact($name,$surname,$email) {
 
        $stmnt = $this->connect()->prepare('CALL create_contact(?,?,?,@contact_id);');

        if(!$stmnt->execute(array($name,$surname,$email))) {
            $stmnt = null;
            header("location: ../../../public/contact-page.php?error=failed_adding_contact");
            exit;
        }

        if($stmnt->rowCount() > 0) {
            $resultCheck = false;
        } else {
            $resultCheck = true;
        }

        return $resultCheck;
    }

    protected function checkContactEmail($email) {
    
        $stmnt = $this->connect()->prepare('CALL check_contact_by_email(?)');
        
        $stmnt->execute(array($email));
        
        $result = $stmnt->fetchAll(PDO::FETCH_ASSOC);

        // Check if any rows are returned in the result
        if (count($result) > 0) {
            return true; // Contact with the email exists
        } else {
            return false; // Contact with the email does not exist
        }

    }
}    