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
            $stmtLinks = $bdd->query("SELECT chapter_id, next_chapter_id, description FROM Links ORDER BY id ASC");
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

                $chapter = new Chapter($id, $title, $description, $image, $choices);
                $chapter->loadMonsters($bdd);
                $this->chapters[] = $chapter;
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
        global $bdd;

        // charger le modèle Chapter
        require_once __DIR__ . '/../models/chapterModel.php';
        require_once __DIR__ . '/../models/fight/MonsterModel.php';

        $chapter = $this->getChapter($id);
        if (!$chapter) {
            header('Location: '.$_SESSION['basepath'].'/404');
            echo "Chapitre non trouvé";
            return;
        }

        // charger les monstres depuis la BDD si besoin
        try {
            $chapter->loadMonsters($bdd);
        } catch (Exception $e) {
            // ignore ou log
            if (defined('DEBUG') && DEBUG) error_log($e->getMessage());
        }

        $character = $_SESSION['character'];

        if (isset($character)) {
            try {
                // 1) Insérer une nouvelle ligne dans Hero_Progress pour ce chapitre (InProgress)
                $stmt = $bdd->prepare("
                    INSERT INTO Hero_Progress (hero_id, chapter_id, status, completion_date, objective)
                    VALUES (:hero_id, :chapter_id, :status, NULL, :objective)
                ");
                $stmt->execute([
                    ':hero_id' => $character->getId(),
                    ':chapter_id' => $id,
                    ':status' => 'InProgress',
                    ':objective' => null
                ]);

                // 2) Mettre à jour le hero.chapter_id et sauvegarder le Hero en base
                $character->setChapterId($id);
            } catch (PDOException $e) {
                if (defined('DEBUG') && DEBUG) {
                    error_log('Erreur insertion Hero_Progress : ' . $e->getMessage());
                }
                // on laisse la vue charger même si l'insertion a échoué
            }
        }

        // inclure la vue (la vue gère affichage combat si monsters non vide)
        require_once __DIR__ . '/../views/chapter.php';
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