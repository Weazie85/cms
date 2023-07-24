<?php 
class ClientContactContr extends ClientContact {

    private $clientId;
    private $contactId;
    
    function __construct(int $clientId, int $contactId) {
        $this->clientId = $clientId;
        $this->contactId = $contactId;
    }

    public function linkClientToContact() {
        
        if ($this->validParam() == false) {
            header("location: ../../../public/client-page.php?IDs_not_valid");
            exit();
        }
        
        if ($this->existsClientContact() == false) {
            header("location: ../../../public/client-page.php?error=client_contact_exists");
            exit();
        }

        $this->insertClientContact($this->clientId, $this->contactId); 
         
    }

    public function unlinkClientFromContact() {
        
        if ($this->validParam() == false) {
            header("location: ../../../public/client-page.php?IDs_not_valid");
            exit();
        }
        
        if (!$this->existsClientContact() == false) {
            header("location: ../../../public/client-page.php?error=client_contact_does_not__exist");
            exit();
        }

        $this->deleteClientContact($this->clientId, $this->contactId); 
         
    }

    // Error handlers
    private function validParam() {
         
        if (filter_var($this->clientId, FILTER_VALIDATE_INT) === false || filter_var($this->contactId, FILTER_VALIDATE_INT) === false) {
            // Ids are not valid integers  
            return false;
        } 

        return true;
    }
     
    private function existsClientContact() {
         
        if($this->checkClientContactId($this->clientId, $this->contactId) == true) {
            return false;
        } else {
            return true;
        }
 
    }
    
}