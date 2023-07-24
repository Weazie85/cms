<?php 
class ClientView extends Client {

    public function getClients() {
         
        $result = $this->qryClients();

        return $result;
    }

}