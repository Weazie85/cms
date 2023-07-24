<?php 
class ClientContr extends Client {

    private $name;
    
    function __construct($name) {
        $this->name = $name;
    }

    public function addClient() {
         
        if ($this->emptyInput() == false) {
            header("location: ../../../public/client-page.php?empty_name_input");
            exit();
        }

        $this->setClient($this->name); 
         
    }

    //Error handlers
    private function emptyInput() {
         
        if(empty($this->name)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }
}