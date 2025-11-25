# Bibliothèque - Gestion de Livres

Application PHP de gestion de bibliothèque utilisant Docker, MySQL et une architecture MVC.

## Prérequis

- Docker
- Docker Compose

## Installation

1. Cloner le projet :
```bash
git clone https://github.com/Saar45/bibliotheque.git
cd bibliotheque
```

2. Créer le fichier de configuration :
```bash
cp config.php.example config.php
```

Si `config.php.example` n'existe pas, créez `config.php` avec :
```php
<?php
define('DB_HOST', getenv('DB_HOST') ?: 'db');
define('DB_NAME', getenv('DB_NAME') ?: 'bibliotheque');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('BASE_URL', '/public');
```

3. Installer les dépendances Composer :
```bash
docker-compose run --rm php composer install
```

## Démarrage

Lancer l'application :
```bash
docker-compose up -d
```

L'application sera accessible à : **http://localhost:8080/public**

## Arrêt

```bash
docker-compose down
```

## Structure

- `public/` - Point d'entrée de l'application
- `src/Controller/` - Contrôleurs
- `src/Model/` - Modèles
- `src/View/` - Vues
- `docker/` - Scripts d'initialisation de la base de données

## Fonctionnalités

- Lister les livres
- Ajouter un livre
- Modifier un livre
- Supprimer un livre
- Afficher les détails d'un livre
