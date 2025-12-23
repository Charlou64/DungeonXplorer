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

    /* ===================== DASHBOARD ===================== */

    public function index() {
        require_once 'views/admin/dashboard.php';
    }

    /* ===================== CHAPTERS ===================== */

    public function chapters() {
        global $bdd;
        $chapters = $bdd->query("SELECT * FROM Chapter")->fetchAll(PDO::FETCH_ASSOC);
        $availableImages = $this->getAvailableImages();
        require_once 'views/admin/chapters.php';
    }

    public function createChapter() {
        global $bdd;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre = trim($_POST['titre']);
            $content = trim($_POST['content']);
            $imageName = $_POST['image_select'];
            $dbPath = ($imageName !== "") ? '../images/chapter/' . $imageName : null;

            $stmt = $bdd->prepare("INSERT INTO Chapter (titre, content, image) VALUES (?, ?, ?)");
            $stmt->execute([$titre, $content, $dbPath]);

            header('Location: ' . $_SESSION["basepath"] . '/admin/chapters');
            exit;
        }
    }

    public function deleteChapter($id) {
        global $bdd;
        $bdd->prepare("DELETE FROM Chapter WHERE id = ?")->execute([$id]);
        header('Location: ' . $_SESSION["basepath"] . '/admin/chapters');
        exit;
    }

    public function addLink() {
        global $bdd;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $stmt = $bdd->prepare("INSERT INTO Links (chapter_id, next_chapter_id, description) VALUES (?, ?, ?)");
            $stmt->execute([$_POST['source'], $_POST['destination'], $_POST['desc']]);
        }
        header('Location: ' . $_SESSION["basepath"] . '/admin/chapters');
        exit;
    }

    /* ===================== MONSTERS ===================== */

    public function monsters() {
        global $bdd;
        $monsters = $bdd->query("SELECT * FROM Monster")->fetchAll(PDO::FETCH_ASSOC);
        $chapters = $bdd->query("SELECT * FROM Chapter")->fetchAll(PDO::FETCH_ASSOC);
        require_once 'views/admin/monsters.php';
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
            $stmt = $bdd->prepare("INSERT INTO Encounter (chapter_id, monster_id) VALUES (?, ?)");
            $stmt->execute([$_POST['chapter_id'], $_POST['monster_id']]);
            header('Location: ' . $_SESSION["basepath"] . '/admin/monsters');
            exit;
        }
    }

    /* ===================== USERS ===================== */

    // Liste des utilisateurs
    public function users() {
        global $bdd;
        $users = $bdd->query("SELECT id, username, email, is_admin, created_at FROM Users ORDER BY id ASC")
                     ->fetchAll(PDO::FETCH_ASSOC);
        require_once 'views/admin/users.php';
    }

    // Création d'un utilisateur
    public function createUser() {
        global $bdd;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $is_admin = isset($_POST['is_admin']) ? 1 : 0;

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $bdd->prepare("INSERT INTO Users (username, password_hash, email, is_admin) VALUES (?, ?, ?, ?)");
            $stmt->execute([$username, $hash, $email, $is_admin]);

            header('Location: ' . $_SESSION["basepath"] . '/admin/users');
            exit;
        }
    }

    // Promotion / rétrogradation admin
    public function toggleAdmin($id) {
        global $bdd;

        // empêcher de se retirer ses propres droits
        $stmt = $bdd->prepare("SELECT username, is_admin FROM Users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || $user['username'] === $_SESSION['username']) {
            header('Location: ' . $_SESSION["basepath"] . '/admin/users');
            exit;
        }

        // empêcher suppression du dernier admin
        if ($user['is_admin'] == 1) {
            $count = $bdd->query("SELECT COUNT(*) FROM Users WHERE is_admin = 1")->fetchColumn();
            if ($count <= 1) {
                header('Location: ' . $_SESSION["basepath"] . '/admin/users');
                exit;
            }
        }

        $new = $user['is_admin'] ? 0 : 1;
        $bdd->prepare("UPDATE Users SET is_admin = ? WHERE id = ?")->execute([$new, $id]);

        header('Location: ' . $_SESSION["basepath"] . '/admin/users');
        exit;
    }

    // Suppression utilisateur
    public function deleteUser($id) {
        global $bdd;

        $stmt = $bdd->prepare("SELECT username, is_admin FROM Users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || $user['username'] === $_SESSION['username']) {
            header('Location: ' . $_SESSION["basepath"] . '/admin/users');
            exit;
        }

        if ($user['is_admin'] == 1) {
            $count = $bdd->query("SELECT COUNT(*) FROM Users WHERE is_admin = 1")->fetchColumn();
            if ($count <= 1) {
                header('Location: ' . $_SESSION["basepath"] . '/admin/users');
                exit;
            }
        }

        $bdd->prepare("DELETE FROM Users WHERE id = ?")->execute([$id]);

        header('Location: ' . $_SESSION["basepath"] . '/admin/users');
        exit;
    }
}
