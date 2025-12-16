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
            $chapterRows = $bdd->query("SELECT id, titre, content, image FROM Chapter ORDER BY id ASC");
            $rows = $chapterRows->fetchAll(PDO::FETCH_ASSOC);

            // 2. Récupération des liens
            $stmtLinks = $bdd->query("SELECT chapter_id, next_chapter_id, description FROM Links ORDER BY chapter_id, next_chapter_id");
            $linkRows = $stmtLinks->fetchAll(PDO::FETCH_ASSOC);

            // 3. Organisation des liens
            $linksByChapter = [];
            foreach ($linkRows as $link) {
                $chapterId = (int) $link['chapter_id'];
                $linksByChapter[$chapterId][] = [
                    'next_chapter_id' => (int) $link['next_chapter_id'],
                    'description' => $link['description']
                ];
            }

            // 4. Construction des objets
            foreach ($rows as $row) {
                $id = (int) $row['id'];
                $title = $row['titre'];
                $description = $row['content'];
                $image = $row['image'] ?? '';

                $choices = $linksByChapter[$id] ?? []; // Récupération des choix

                $this->chapters[] = new Chapter($id, $title, $description, $image, $choices);
            }
        } catch (PDOException $e) {
            if (defined('DEBUG') && DEBUG) {
                error_log('Erreur BDD dans ChapterController::__construct : ' . $e->getMessage());
            }
            $this->chapters = [];
        }
    }

    public function show($id)
    {
        $chapter = $this->getChapter($id);

        // s'assurer que la classe Character est disponible (pour save())
        require_once __DIR__ . '/../models/characterModel.php';

        if ($chapter && isset($_SESSION['character']) && $_SESSION['character'] instanceof Character) {
            global $bdd;

            $hero = $_SESSION['character'];
            $heroId = $hero->getId();

            if ($heroId) {
                try {
                    // 1) Insérer une nouvelle ligne dans Hero_Progress pour ce chapitre (InProgress)
                    $stmt = $bdd->prepare("
                        INSERT INTO Hero_Progress (hero_id, chapter_id, status, completion_date, objective)
                        VALUES (:hero_id, :chapter_id, :status, NULL, :objective)
                    ");
                    $stmt->execute([
                        ':hero_id' => $heroId,
                        ':chapter_id' => $id,
                        ':status' => 'InProgress',
                        ':objective' => null
                    ]);

                    // 2) Mettre à jour le hero.chapter_id et sauvegarder le Hero en base
                    $hero->setChapterId($id);

                    // mettre à jour l'objet en session au cas où save modifie l'objet (id, etc.)
                    $_SESSION['character'] = $hero;
                } catch (PDOException $e) {
                    if (defined('DEBUG') && DEBUG) {
                        error_log('Erreur insertion Hero_Progress : ' . $e->getMessage());
                    }
                    // on laisse la vue charger même si l'insertion a échoué
                }
            }

            include 'views/chapter.php'; // Charge la vue pour le chapitre
        } else {
            // Si le chapitre n'existe pas ou pas de personnage en session, affiche une erreur
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
