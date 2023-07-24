<?php

class Client extends Dbh {

    protected function qryClients() {

        $stmnt = $this->connect()->prepare('CALL get_clients;');
        
        if(!$stmnt->execute()) {
            $stmnt = null;
            exit;
        }
 
        $results = $stmnt->fetchAll(PDO::FETCH_ASSOC);
 
        return $results;
         
    }

    protected function setClient($name) {
        
        $stmnt = $this->connect()->prepare('CALL create_client(?)');

        if(!$stmnt->execute(array($name))) {
            $stmnt = null;
            header("location: ../../../public/client-page.php?error=failed_adding_client");
            exit;
        }
 
        if($stmnt->rowCount() > 0) {
            $resultCheck = false;
        } else {
            $resultCheck = true;
        }

        return $resultCheck;
    }
}    