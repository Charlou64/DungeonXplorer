<?php
class AdminController {
    
    public function __construct() {
        // Sécurité : Vérifie si l'utilisateur est admin
        if (!isset($_SESSION['username']) || !$this->isAdmin()) {
            header('Location: ' . $_SESSION["basepath"] . '/account/signIn');
            exit;
        }
    }

    private function isAdmin() {
        global $bdd;
        $stmt = $bdd->prepare("SELECT is_admin FROM Users WHERE username = ?");
        $stmt->execute([$_SESSION['username']]);
        return $stmt->fetchColumn() == 1;
    }

    private function getAvailableImages() {
        $imageFolder = $_SERVER['DOCUMENT_ROOT'] . $_SESSION["basepath"] . '/images/chapter/';
        $availableImages = [];
        if (is_dir($imageFolder)) {
            $files = scandir($imageFolder);
            foreach ($files as $file) {
                if (in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp'])) {
                    $availableImages[] = $file;
                }
            }
        }
        return $availableImages;
    }

    public function index() {
        require_once 'views/admin/dashboard.php';
    }

    public function chapters() {
        global $bdd;
        $chapters = $bdd->query("SELECT * FROM Chapter")->fetchAll(PDO::FETCH_ASSOC);
        $availableImages = $this->getAvailableImages();
        require_once 'views/admin/chapters.php';
    }

    public function monsters() {
        global $bdd;
        $monsters = $bdd->query("SELECT * FROM Monster")->fetchAll(PDO::FETCH_ASSOC);
        $chapters = $bdd->query("SELECT * FROM Chapter")->fetchAll(PDO::FETCH_ASSOC);
        require_once 'views/admin/monsters.php';
    }

    public function createChapter() {
        global $bdd;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre = trim($_POST['titre']);
            $content = trim($_POST['content']);
            $imageName = $_POST['image_select']; // On récupère le nom choisi

            // On reconstruit le chemin relatif pour la BDD
            $dbPath = ($imageName !== "") ? '../images/chapter/' . $imageName : null;

            $stmt = $bdd->prepare("INSERT INTO Chapter (titre, content, image) VALUES (?, ?, ?)");
            $stmt->execute([$titre, $content, $dbPath]);

            header('Location: ' . $_SESSION["basepath"] . '/admin/chapters');
            exit;
        }
    }

    public function deleteChapter($id) {
        global $bdd;
        // Les liens (Links) seront supprimés automatiquement via ON DELETE CASCADE dans votre SQL
        $bdd->prepare("DELETE FROM Chapter WHERE id = ?")->execute([$id]);
        header('Location: ' . $_SESSION["basepath"] . '/admin/chapters');
    }

    public function addLink() {
        global $bdd;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $stmt = $bdd->prepare("INSERT INTO Links (chapter_id, next_chapter_id, description) VALUES (?, ?, ?)");
            $stmt->execute([$_POST['source'], $_POST['destination'], $_POST['desc']]);
        }
        header('Location: ' . $_SESSION["basepath"] . '/admin/chapters');
    }

    public function createMonster() {
        global $bdd;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $stmt = $bdd->prepare("INSERT INTO Monster (name, pv, mana, initiative, strength, attack, xp) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['name'], $_POST['pv'], $_POST['mana'], 
                $_POST['initiative'], $_POST['strength'], $_POST['attack'], $_POST['xp']
            ]);
            header('Location: ' . $_SESSION["basepath"] . '/admin/monsters');
            exit;
        }
    }

    public function linkMonster() {
        global $bdd;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // On utilise la table Encounter pour lier un monstre à un chapitre
            $stmt = $bdd->prepare("INSERT INTO Encounter (chapter_id, monster_id) VALUES (?, ?)");
            $stmt->execute([$_POST['chapter_id'], $_POST['monster_id']]);
            header('Location: ' . $_SESSION["basepath"] . '/admin/monsters');
            exit;
        }
    }
}