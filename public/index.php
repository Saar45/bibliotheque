<?php
/**
 * Point d'entrée principal de l'application
 */

// Démarrer la session
session_start();

// Charger la configuration
require_once __DIR__ . '/../config.php';

// Charger l'autoloader de Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Initialiser le routeur et dispatcher
use App\Router;

$router = new Router();
$router->dispatch();
