<?php

namespace App\Controller;

use App\Model\Livre;

class LivreController
{
    private Livre $livreModel;

    public function __construct()
    {
        $this->livreModel = new Livre();
    }

    public function index(): void
    {
        $livres = $this->livreModel->getAll();
        $this->render('livres/index', ['livres' => $livres]);
    }
    public function create(): void
    {
        $this->render('livres/create');
    }
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validation et sécurité
            $titre = trim($_POST['titre'] ?? '');
            $auteur = trim($_POST['auteur'] ?? '');
            $annee = filter_var($_POST['annee'] ?? 0, FILTER_VALIDATE_INT);

            $errors = [];

            if (empty($titre)) {
                $errors[] = "Le titre est obligatoire.";
            }

            if (empty($auteur)) {
                $errors[] = "L'auteur est obligatoire.";
            }

            if (!$annee || $annee < 0 || $annee > date('Y')) {
                $errors[] = "L'année n'est pas valide.";
            }

            if (empty($errors)) {
                if ($this->livreModel->create($titre, $auteur, $annee)) {
                    $_SESSION['success'] = "Le livre a été ajouté avec succès.";
                    $this->redirect('/');
                } else {
                    $_SESSION['error'] = "Erreur lors de l'ajout du livre.";
                }
            } else {
                $_SESSION['errors'] = $errors;
            }

            $this->redirect('/create');
        }
    }

    public function show(int $id): void
    {
        $livre = $this->livreModel->getById($id);

        if (!$livre) {
            $_SESSION['error'] = "Livre non trouvé.";
            $this->redirect('/');
            return;
        }

        $this->render('livres/show', ['livre' => $livre]);
    }

    public function edit(int $id): void
    {
        $livre = $this->livreModel->getById($id);

        if (!$livre) {
            $_SESSION['error'] = "Livre non trouvé.";
            $this->redirect('/');
            return;
        }

        $this->render('livres/edit', ['livre' => $livre]);
    }

    public function update(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validation et sécurité
            $titre = trim($_POST['titre'] ?? '');
            $auteur = trim($_POST['auteur'] ?? '');
            $annee = filter_var($_POST['annee'] ?? 0, FILTER_VALIDATE_INT);

            $errors = [];

            if (empty($titre)) {
                $errors[] = "Le titre est obligatoire.";
            }

            if (empty($auteur)) {
                $errors[] = "L'auteur est obligatoire.";
            }

            if (!$annee || $annee < 0 || $annee > date('Y')) {
                $errors[] = "L'année n'est pas valide.";
            }

            if (empty($errors)) {
                if ($this->livreModel->update($id, $titre, $auteur, $annee)) {
                    $_SESSION['success'] = "Le livre a été modifié avec succès.";
                    $this->redirect('/');
                } else {
                    $_SESSION['error'] = "Erreur lors de la modification du livre.";
                }
            } else {
                $_SESSION['errors'] = $errors;
            }

            $this->redirect('/edit/' . $id);
        }
    }

    public function destroy(int $id): void
    {
        if ($this->livreModel->delete($id)) {
            $_SESSION['success'] = "Le livre a été supprimé avec succès.";
        } else {
            $_SESSION['error'] = "Erreur lors de la suppression du livre.";
        }

        $this->redirect('/');
    }

    private function render(string $view, array $data = []): void
    {
        extract($data);
        require_once __DIR__ . '/../View/' . $view . '.php';
    }
    private function redirect(string $path): void
    {
        header('Location: ' . BASE_URL . $path);
        exit;
    }
}
