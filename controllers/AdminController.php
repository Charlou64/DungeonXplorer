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

    public function index() {
        global $bdd;
        
        // Récupération des chapitres pour le tableau
        $chapters = $bdd->query("SELECT * FROM Chapter")->fetchAll(PDO::FETCH_ASSOC);

        // Scan du dossier pour lister les images disponibles
        $imageFolder = $_SERVER['DOCUMENT_ROOT'] . $_SESSION["basepath"] . '/images/chapter/';
        $availableImages = [];
        
        if (is_dir($imageFolder)) {
            // scandir liste les fichiers. On filtre pour ne garder que les images
            $files = scandir($imageFolder);
            foreach ($files as $file) {
                $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    $availableImages[] = $file;
                }
            }
        }

        require_once 'views/admin/dashboard.php';
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
            
            header('Location: ' . $_SESSION["basepath"] . '/admin');
            exit;
        }
    }

    public function deleteChapter($id) {
        global $bdd;
        // Les liens (Links) seront supprimés automatiquement via ON DELETE CASCADE dans votre SQL
        $bdd->prepare("DELETE FROM Chapter WHERE id = ?")->execute([$id]);
        header('Location: ' . $_SESSION["basepath"] . '/admin');
    }

    public function addLink() {
        global $bdd;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $stmt = $bdd->prepare("INSERT INTO Links (chapter_id, next_chapter_id, description) VALUES (?, ?, ?)");
            $stmt->execute([$_POST['source'], $_POST['destination'], $_POST['desc']]);
        }
        header('Location: ' . $_SESSION["basepath"] . '/admin');
    }
}