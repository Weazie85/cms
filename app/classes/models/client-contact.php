<?php

class ClientContact extends Dbh {

    protected function qryClientContacts($clientId) {

        $stmnt = $this->connect()->prepare('call get_client_contacts(?);');

        if(!$stmnt->execute(array($clientId))) {
            $stmnt = null;
            exit;
        }
 
        $results = $stmnt->fetchAll(PDO::FETCH_ASSOC);

        return $results;

    }

    protected function insertClientContact($clientId,$contactId) {
 
        $stmnt = $this->connect()->prepare('CALL link_contact_to_client(?,?)');

        if(!$stmnt->execute(array($clientId,$contactId))) {
            $stmnt = null;
            header("location: ../../../public/client-page.php?error_executing_query");
            exit;
        }

        if($stmnt->rowCount() > 0) {
            $resultCheck = false;
        } else {
            $resultCheck = true;
        }

        return $resultCheck;
    }

    protected function deleteClientContact($clientId,$contactId) {
 
        $stmnt = $this->connect()->prepare('CALL unlink_contact_from_client(?,?)');

        if(!$stmnt->execute(array($clientId,$contactId))) {
            $stmnt = null;
            header("location: ../../../public/client-page.php?error_executing_query");
            exit;
        }

        if($stmnt->rowCount() > 0) {
            $resultCheck = false;
        } else {
            $resultCheck = true;
        }

        return $resultCheck;
    }

    protected function checkClientContactId($clientId, $contactId) {
    
        $stmnt = $this->connect()->prepare('CALL check_contact_client_id(?,?);');
        
        $stmnt->execute(array($clientId, $contactId));
        
        $result = $stmnt->fetchAll(PDO::FETCH_ASSOC);

        // Check if any rows are returned in the result
        if (count($result) > 0) {
            return true; 
        } else {
            return false;  
        }

    }
 
}    