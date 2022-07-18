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
            
            $row["applied"] = (bool) $row["applied"];
            
            $data[] = $row;
        }
        
        return $data;
    }
    
    public function create(array $data): string
    {
        $sql = "INSERT INTO job (reference, detail, applied)
                VALUES (:reference, :detail, :applied)";
                
        $stmt = $this->cnx->prepare($sql);
        
        $stmt->bindValue(":reference", $data["reference"], PDO::PARAM_STR);
        $stmt->bindValue(":detail", $data["detail"] ?? 0, PDO::PARAM_INT);
        $stmt->bindValue(":applied", (bool) ($data["applied"] ?? false), PDO::PARAM_BOOL);
        
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
            $data["applied"] = (bool) $data["applied"];
        }
        
        return $data;
    }
    
    public function update(array $current, array $new): int
    {
        $sql = "UPDATE job
                SET reference = :reference, detail = :detail, applied = :applied
                WHERE id = :id";
                
        $stmt = $this->cnx->prepare($sql);
        
        $stmt->bindValue(":reference", $new["reference"] ?? $current["reference"], PDO::PARAM_STR);
        $stmt->bindValue(":detail", $new["detail"] ?? $current["detail"], PDO::PARAM_INT);
        $stmt->bindValue(":applied", $new["applied"] ?? $current["applied"], PDO::PARAM_BOOL);
        
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