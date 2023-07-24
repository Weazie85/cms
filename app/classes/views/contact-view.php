<?php

class ContactView extends Contact {
 
    public function getContacts() {
        
        $results = $this->qryContacts();

        return $results; 
    }


}