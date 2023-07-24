<?php

class ContactContr extends Contact {
 
    private $name;
    private $surname;
    private $email;
    
    function __construct($name, $surname, $email) {
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
    }
 
    public function addContact() {
        
        if ($this->emptyInput() == false) {
            header("location: ../../../public/contact-page.php?error=empty_input_fields");
            exit();
        }

        if ($this->validEmail() == false) {
            header("location: ../../../public/contact-page.php?error=invalid_email_address");
            exit();
        }

        if ($this->emailUsed() == false) {
            header("location: ../../../public/contact-page.php?error=email_address_used");
            exit();
        }

        $this->setContact($this->name, $this->surname, $this->email);   
         
    }

    //Error handlers
    private function emptyInput() {
         
        if(empty($this->name) || empty($this->surname) || empty($this->email)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    private function emailUsed() {
         
        if($this->checkContactEmail($this->email) == true) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    private function validEmail() {
        
        if(filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false) {
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }

}