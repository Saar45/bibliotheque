<?php

namespace App\Model;

use PDO;

class Livre
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function create(string $titre, string $auteur, int $annee): bool
    {
        $sql = "INSERT INTO livres (titre, auteur, annee) VALUES (:titre, :auteur, :annee)";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':titre' => htmlspecialchars($titre, ENT_QUOTES, 'UTF-8'),
            ':auteur' => htmlspecialchars($auteur, ENT_QUOTES, 'UTF-8'),
            ':annee' => $annee
        ]);
    }


    public function getAll(): array
    {
        $sql = "SELECT * FROM livres ORDER BY id DESC";
        $stmt = $this->db->query($sql);
        
        return $stmt->fetchAll();
    }


    public function getById(int $id): array|false
    {
        $sql = "SELECT * FROM livres WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        return $stmt->fetch();
    }


    public function update(int $id, string $titre, string $auteur, int $annee): bool
    {
        $sql = "UPDATE livres SET titre = :titre, auteur = :auteur, annee = :annee WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':id' => $id,
            ':titre' => htmlspecialchars($titre, ENT_QUOTES, 'UTF-8'),
            ':auteur' => htmlspecialchars($auteur, ENT_QUOTES, 'UTF-8'),
            ':annee' => $annee
        ]);
    }


    public function delete(int $id): bool
    {
        $sql = "DELETE FROM livres WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([':id' => $id]);
    }
}