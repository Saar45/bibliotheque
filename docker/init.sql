-- Création de la table livres
CREATE TABLE IF NOT EXISTS livres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    auteur VARCHAR(255) NOT NULL,
    annee INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertion de données de test
INSERT INTO livres (titre, auteur, annee) VALUES
('Le Petit Prince', 'Antoine de Saint-Exupéry', 1943),
('1984', 'George Orwell', 1949),
('L\'Étranger', 'Albert Camus', 1942),
('Harry Potter à l\'école des sorciers', 'J.K. Rowling', 1997),
('Le Seigneur des Anneaux', 'J.R.R. Tolkien', 1954),
('Pride and Prejudice', 'Jane Austen', 1813),
('Les Misérables', 'Victor Hugo', 1862),
('Cent ans de solitude', 'Gabriel García Márquez', 1967),
('La Peste', 'Albert Camus', 1947),
('Le Comte de Monte-Cristo', 'Alexandre Dumas', 1844);
