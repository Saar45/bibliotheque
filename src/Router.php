<?php

namespace App;

use App\Controller\LivreController;

/**
 * Classe Router - Gestion du routage de l'application
 */
class Router
{
    private string $uri;
    private string $method;

    public function __construct()
    {
        $this->uri = $this->getUri();
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Récupérer l'URI nettoyée
     */
    private function getUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'];
        
        // Retirer les paramètres de query string
        $uri = parse_url($uri, PHP_URL_PATH);
        
        // Retirer le base URL (/public)
        if (strpos($uri, BASE_URL) === 0) {
            $uri = substr($uri, strlen(BASE_URL));
        }
        
        // Retirer les slashes multiples
        $uri = preg_replace('#/+#', '/', $uri);
        
        // S'assurer qu'on a au moins un slash
        if (empty($uri)) {
            $uri = '/';
        }
        
        return $uri;
    }

    /**
     * Router les requêtes vers les contrôleurs
     */
    public function dispatch(): void
    {
        $controller = new LivreController();

        // Routes GET
        if ($this->method === 'GET') {
            // Page d'accueil - Liste des livres
            if ($this->uri === '/' || $this->uri === '') {
                $controller->index();
                return;
            }

            // Formulaire de création
            if ($this->uri === '/create') {
                $controller->create();
                return;
            }

            // Afficher un livre - /show/{id}
            if (preg_match('#^/show/(\d+)$#', $this->uri, $matches)) {
                $controller->show((int)$matches[1]);
                return;
            }

            // Formulaire d'édition - /edit/{id}
            if (preg_match('#^/edit/(\d+)$#', $this->uri, $matches)) {
                $controller->edit((int)$matches[1]);
                return;
            }
        }

        // Routes POST
        if ($this->method === 'POST') {
            // Créer un livre
            if ($this->uri === '/store') {
                $controller->store();
                return;
            }

            // Mettre à jour un livre - /update/{id}
            if (preg_match('#^/update/(\d+)$#', $this->uri, $matches)) {
                $controller->update((int)$matches[1]);
                return;
            }

            // Supprimer un livre - /delete/{id}
            if (preg_match('#^/delete/(\d+)$#', $this->uri, $matches)) {
                $controller->destroy((int)$matches[1]);
                return;
            }
        }

        // Route non trouvée
        $this->notFound();
    }

    /**
     * Page 404
     */
    private function notFound(): void
    {
        http_response_code(404);
        echo '<h1>404 - Page non trouvée</h1>';
        echo '<p>La page que vous recherchez n\'existe pas.</p>';
        echo '<a href="' . BASE_URL . '/">Retour à l\'accueil</a>';
    }
}
