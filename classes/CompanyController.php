<?php
class CompanyController{

    public function __construct(CompanyManager $companyManager)
    {
    }

    public function processRequest(string $method, ?string $id): void
    {
        if ($id) {
            
            echo $id ;
            
        } else {
            
            echo $method;
            
        }
    }
}

?>