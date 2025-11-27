<?php

// controllers/ChapterController.php

require_once 'models/chapterModel.php';
require_once 'models/connexion.php';

class ChapterController
{
    private $chapters = [];

    public function __construct()
    {
        global $bdd;

        try {
            $stmt = $bdd->query("SELECT id, content, image FROM Chapter ORDER BY id ASC");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                $id = (int) $row['id'];
                $content = $row['content'];
                $image = $row['image'] ?? '';

                // Adaptation : la table ne contient pas de title/choices => valeurs par défaut
                $title = "Chapitre " . $id;
                $description = $content;
                $choices = []; // à gérer plus tard si stockés en base

                $this->chapters[] = new Chapter($id, $title, $description, $image, $choices);
            }
        } catch (PDOException $e) {
            if (defined('DEBUG') && DEBUG) {
                error_log('Erreur requête Chapter : ' . $e->getMessage());
            }
            $this->chapters = [];
        }
    }

    public function show($id)
    {
        $chapter = $this->getChapter($id);

        if ($chapter) {
            include 'views/chapter.php'; // Charge la vue pour le chapitre
        } else {
            // Si le chapitre n'existe pas, redirige vers un chapitre par défaut ou affiche une erreur
            include 'views/404.php';
        }
    }

    public function getChapter($id)
    {
        foreach ($this->chapters as $chapter) {
            if ($chapter->getId() == $id) {
                return $chapter;
            }
        }
        return null; // Chapitre non trouvé
    }
}
