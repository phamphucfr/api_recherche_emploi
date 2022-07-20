<?php

require_once(realpath(__DIR__ . '/..').'../tools/dbConnexion.php');

class JobManager
{
    private PDO $cnx;
    
    public function __construct()
    {
        $this->cnx = dbconnexion::connect();
    }
    
    public function getAll(): array
    {
        $sql = "SELECT *
                FROM job";
                
        $stmt = $this->cnx->query($sql);
        
        $data = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            
            $row["is_is_applied"] = (bool) $row["is_is_applied"];
            
            $data[] = $row;
        }
        
        return $data;
    }
    
    public function create(array $data): string
    {
        $sql = "INSERT INTO job (reference, description, is_applied)
                VALUES (:reference, :description, :is_applied)";
                
        $stmt = $this->cnx->prepare($sql);
        
        $stmt->bindValue(":reference", $data["reference"], PDO::PARAM_STR);
        $stmt->bindValue(":description", $data["description"] ?? 0, PDO::PARAM_INT);
        $stmt->bindValue(":is_applied", (bool) ($data["is_applied"] ?? false), PDO::PARAM_BOOL);
        
        $stmt->execute();
        
        return $this->cnx->lastInsertId();
    }
    
    public function get(string $id): array
    {
        $sql = "SELECT *
                FROM job
                WHERE id = :id";
                
        $stmt = $this->cnx->prepare($sql);
        
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        
        $stmt->execute();
        
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($data !== false) {
            $data["is_applied"] = (bool) $data["is_applied"];
        }
        
        return $data;
    }
    
    public function update(array $current, array $new): int
    {
        $sql = "UPDATE job
                SET reference = :reference, description = :description, is_applied = :is_applied
                WHERE id = :id";
                
        $stmt = $this->cnx->prepare($sql);
        
        $stmt->bindValue(":reference", $new["reference"] ?? $current["reference"], PDO::PARAM_STR);
        $stmt->bindValue(":description", $new["description"] ?? $current["description"], PDO::PARAM_INT);
        $stmt->bindValue(":is_applied", $new["is_applied"] ?? $current["is_applied"], PDO::PARAM_BOOL);
        
        $stmt->bindValue(":id", $current["id"], PDO::PARAM_INT);
        
        $stmt->execute();
        
        return $stmt->rowCount();
    }
    
    public function delete(string $id): int
    {
        $sql = "DELETE FROM job
                WHERE id = :id";
                
        $stmt = $this->cnx->prepare($sql);
        
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        
        $stmt->execute();
        
        return $stmt->rowCount();
    }
}

?>