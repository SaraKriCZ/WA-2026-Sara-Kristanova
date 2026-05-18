<?php
require_once '../app/models/Database.php';
require_once '../app/models/Review.php';
require_once '../app/models/User.php';
require_once '../app/models/Comment.php';

class ProfileController {
    private $db;
    private $review;
    private $user;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) session_start();
        $database     = new Database();
        $this->db     = $database->getConnection();
        $this->review = new Review($this->db);
        $this->user   = new User($this->db);
    }

    private function requireLogin() {
        if (!isset($_SESSION['user_id'])) { header("Location: ?url=user/login"); exit(); }
    }

    private function requireAdmin() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: ?url=review/index"); exit();
        }
    }

    public function index() {
        $this->requireLogin();
        $stmt          = $this->review->readByUser($_SESSION['user_id']);
        $my_reviews    = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $total_reviews = count($my_reviews);
        require '../app/views/profile/index.php';
    }

    public function edit() {
        $this->requireLogin();
        require '../app/views/profile/edit.php';
    }

    public function update() {
        $this->requireLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: ?url=profile/index"); exit(); }

        $current = $_POST['current_password'] ?? '';
        $new     = $_POST['new_password']     ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        $stmt = $this->db->prepare("SELECT password FROM users WHERE id=?");
        $stmt->execute([$_SESSION['user_id']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $errors = [];
        if (!password_verify($current, $row['password'])) $errors[] = 'Aktuální heslo není správné.';
        if (strlen($new) < 8)                             $errors[] = 'Nové heslo musí mít alespoň 8 znaků.';
        if (!preg_match('/[0-9]/', $new))                 $errors[] = 'Nové heslo musí obsahovat číslici.';
        if (!preg_match('/[A-Z]/', $new))                 $errors[] = 'Nové heslo musí obsahovat velké písmeno.';
        if ($new !== $confirm)                            $errors[] = 'Hesla se neshodují.';

        if (!empty($errors)) {
            $error_message = implode('<br>', $errors);
            require '../app/views/profile/edit.php';
            return;
        }

        $this->user->updatePassword($_SESSION['user_id'], password_hash($new, PASSWORD_BCRYPT));
        header("Location: ?url=profile/index&success=password");
        exit();
    }

    public function deleteAccount() {
        $this->requireLogin();
        $this->user->delete($_SESSION['user_id']);
        $_SESSION = []; session_destroy();
        header("Location: ?url=review/index"); exit();
    }

    // ── ADMIN ─────────────────────────────────────────────

    public function adminUsers() {
        $this->requireAdmin();
        $users = $this->user->getAll();
        require '../app/views/admin/users.php';
    }

    public function adminDeleteUser() {
        $this->requireAdmin();
        $id = $_GET['id'] ?? null;
        if ($id && $id != $_SESSION['user_id']) $this->user->delete($id);
        header("Location: ?url=profile/adminUsers&deleted=1"); exit();
    }

    // Seznam všech recenzí pro admina
    public function adminReviews() {
        $this->requireAdmin();
        $stmt    = $this->db->query(
            "SELECT r.*, u.username FROM reviews r
             JOIN users u ON r.user_id = u.id
             ORDER BY r.id DESC"
        );
        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require '../app/views/admin/reviews.php';
    }

    // Seznam všech komentářů pro admina
    public function adminComments() {
        $this->requireAdmin();
        $stmt = $this->db->query(
            "SELECT c.*, u.username, r.brand, r.model FROM comments c
             JOIN users u ON c.user_id = u.id
             JOIN reviews r ON c.review_id = r.id
             ORDER BY c.id DESC"
        );
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require '../app/views/admin/comments.php';
    }

    // Admin smaže komentář
    public function adminDeleteComment() {
        $this->requireAdmin();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $stmt = $this->db->prepare("DELETE FROM comments WHERE id=?");
            $stmt->execute([$id]);
        }
        header("Location: ?url=profile/adminComments&deleted=1"); exit();
    }
}
?>
