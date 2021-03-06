<?php

class JobController
{

    public function __construct(JobManager $jobManager)
    {
    }
    
    public function processRequest(string $method, ?string $id): void
    {
        if ($id) {
            
            $this->processResourceRequest($method, $id);
            
        } else {
            
            $this->processCollectionRequest($method);
            
        }
    }
    
    private function processResourceRequest(string $method, string $id): void
    {
        $job = $this->jobManager->get($id);
        
        if ( ! $job) {
            http_response_code(404);
            echo json_encode(["message" => "Offre d'emploi n'est pas trouvé"]);
            return;
        }
        
        switch ($method) {
            case "GET":
                echo json_encode($job);
                break;
                
            case "PATCH":
                $data = (array) json_decode(file_get_contents("php://input"), true);
                
                $errors = $this->getValidationErrors($data, false);
                
                if ( ! empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }
                
                $rows = $this->jobManager->update($job, $data);
                
                echo json_encode([
                    "message" => "Offre d'emploi $id mis à jour",
                    "rows" => $rows
                ]);
                break;
                
            case "DELETE":
                $rows = $this->jobManager->delete($id);
                
                echo json_encode([
                    "message" => "Offre d'emploi $id est enlevé",
                    "rows" => $rows
                ]);
                break;
                
            default:
                http_response_code(405);
                header("Allow: GET, PATCH, DELETE");
        }
    }
    
    private function processCollectionRequest(string $method): void
    {
        switch ($method) {
            case "GET":
                echo json_encode($this->jobManager->getAll());
                break;
                
            case "POST":
                $data = (array) json_decode(file_get_contents("php://input"), true);
                
                $errors = $this->getValidationErrors($data);
                
                if ( ! empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }
                
                $id = $this->jobManager->create($data);
                
                http_response_code(201);
                echo json_encode([
                    "message" => "Offre d'emploi ajouté à la liste de gestion",
                    "id" => $id
                ]);
                break;
            
            default:
                http_response_code(405);
                header("Allow: GET, POST");
        }
    }
    
    private function getValidationErrors(array $data, bool $is_new = true): array
    {
        $errors = [];
        
        if ($is_new && empty($data["reference"])) {
            $errors[] = "La référence d'offre d'emploi est exigée";
        }
        
        if (array_key_exists("detail", $data)) {
            if (filter_var($data["detail"], FILTER_VALIDATE_INT) === false) {
                $errors[] = "";
            }
        }
        
        return $errors;
    }
}


?>