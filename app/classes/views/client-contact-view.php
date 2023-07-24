<?php

class CLientContactView extends ClientContact {
 
    public function getClientContacts($clientId) {
        
        $results = $this->qryClientContacts($clientId);

        return $results; 
    }


}