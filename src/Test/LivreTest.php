<?php

namespace App\Test;

use App\Model\Livre;
use App\Model\Database;
use PHPUnit\Framework\TestCase;
use PDO;

class LivreTest extends TestCase
{
    private Livre $livre;
    private PDO $db;

    protected function setUp(): void
    {
        parent::setUp();
        $this->livre = new Livre();
        $this->db = Database::getInstance();
        
        // Clean up test data before each test
        //$this->db->exec("DELETE FROM livres WHERE titre LIKE 'Test%'");
    }

   // protected function tearDown(): void
   // {
        // Clean up test data after each test
       // $this->db->exec("DELETE FROM livres WHERE titre LIKE 'Test%'");
       // parent::tearDown();
   // }

    public function testCreate(): void
    {
        $result = $this->livre->create('Test Livre', 'Test Auteur', 2023);
        
        $this->assertTrue($result, 'Le livre devrait être créé avec succès');
        
        // Verify the book was actually inserted
        $stmt = $this->db->query("SELECT * FROM livres WHERE titre = 'Test Livre'");
        $livre = $stmt->fetch();
        
        $this->assertNotFalse($livre, 'Le livre devrait exister dans la base de données');
        $this->assertEquals('Test Livre', $livre['titre']);
        $this->assertEquals('Test Auteur', $livre['auteur']);
        $this->assertEquals(2023, $livre['annee']);
    }

    public function testGetAll(): void
    {
        // Insert test data
        $this->livre->create('Test Livre 1', 'Test Auteur 1', 2021);
        $this->livre->create('Test Livre 2', 'Test Auteur 2', 2022);
        
        $livres = $this->livre->getAll();
        
        $this->assertIsArray($livres, 'getAll devrait retourner un tableau');
        $this->assertGreaterThanOrEqual(2, count($livres), 'Il devrait y avoir au moins 2 livres');
    }

    public function testGetById(): void
    {
        // Insert a test book
        $this->livre->create('Test Livre GetById', 'Test Auteur', 2023);
        
        // Get the inserted book ID
        $stmt = $this->db->query("SELECT id FROM livres WHERE titre = 'Test Livre GetById' ORDER BY id DESC LIMIT 1");
        $insertedId = $stmt->fetchColumn();
        
        $livre = $this->livre->getById($insertedId);
        
        $this->assertIsArray($livre, 'getById devrait retourner un tableau');
        $this->assertEquals('Test Livre GetById', $livre['titre']);
        $this->assertEquals('Test Auteur', $livre['auteur']);
    }

    public function testGetByIdNotFound(): void
    {
        $livre = $this->livre->getById(999999);
        
        $this->assertFalse($livre, 'getById devrait retourner false pour un ID inexistant');
    }

    public function testUpdate(): void
    {
        // Insert a test book
        $this->livre->create('Test Livre Original', 'Test Auteur Original', 2020);
        
        // Get the inserted book ID
        $stmt = $this->db->query("SELECT id FROM livres WHERE titre = 'Test Livre Original' ORDER BY id DESC LIMIT 1");
        $insertedId = $stmt->fetchColumn();
        
        // Update the book
        $result = $this->livre->update($insertedId, 'Test Livre Modifié', 'Test Auteur Modifié', 2024);
        
        $this->assertTrue($result, 'La mise à jour devrait réussir');
        
        // Verify the update
        $livre = $this->livre->getById($insertedId);
        $this->assertEquals('Test Livre Modifié', $livre['titre']);
        $this->assertEquals('Test Auteur Modifié', $livre['auteur']);
        $this->assertEquals(2024, $livre['annee']);
    }

    public function testDelete(): void
    {
        // Insert a test book
        $this->livre->create('Test Livre Delete', 'Test Auteur', 2023);
        
        // Get the inserted book ID
        $stmt = $this->db->query("SELECT id FROM livres WHERE titre = 'Test Livre Delete' ORDER BY id DESC LIMIT 1");
        $insertedId = $stmt->fetchColumn();
        
        // Delete the book
        $result = $this->livre->delete($insertedId);
        
        $this->assertTrue($result, 'La suppression devrait réussir');
        
        // Verify the book was deleted
        $livre = $this->livre->getById($insertedId);
        $this->assertFalse($livre, 'Le livre ne devrait plus exister après suppression');
    }

    public function testCreateWithHtmlSpecialChars(): void
    {
        $result = $this->livre->create('Test <script>alert("XSS")</script>', 'Test "Auteur"', 2023);
        
        $this->assertTrue($result, 'Le livre devrait être créé même avec des caractères spéciaux');
        
        // Verify HTML entities are escaped
        $stmt = $this->db->query("SELECT * FROM livres WHERE titre LIKE 'Test%script%'");
        $livre = $stmt->fetch();
        
        $this->assertNotFalse($livre, 'Le livre devrait exister');
        $this->assertStringContainsString('&lt;', $livre['titre'], 'Les caractères HTML devraient être échappés');
    }
}