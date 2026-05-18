<?php
require_once '../app/models/Database.php';
require_once '../app/models/Comment.php';

class CommentController {
    private $db;
    private $comment;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) session_start();
        $database      = new Database();
        $this->db      = $database->getConnection();
        $this->comment = new Comment($this->db);
    }

    private function isAdmin(): bool {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    // ── CREATE ───────────────────────────────────────────────
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
            header("Location: ?url=review/index"); exit();
        }
        $this->comment->review_id    = $_POST['review_id'];
        $this->comment->user_id      = $_SESSION['user_id'];
        $this->comment->comment_text = $_POST['comment_text'];
        if ($this->comment->create()) {
            header("Location: ?url=review/show&id=" . $_POST['review_id']);
        }
        exit();
    }

    // ── EDIT FORM ────────────────────────────────────────────
    public function edit() {
        if (!isset($_SESSION['user_id'], $_GET['id'])) {
            header("Location: ?url=review/index"); exit();
        }
        $this->comment->id = $_GET['id'];
        $comment = $this->comment->readOne();

        if ($comment['user_id'] != $_SESSION['user_id'] && !$this->isAdmin()) {
            header("Location: ?url=review/show&id=" . $comment['review_id']); exit();
        }

        // Předáme název vozu do view jako proměnnou (ne přes $this->db)
        $rstmt = $this->db->prepare("SELECT brand, model FROM reviews WHERE id = ?");
        $rstmt->execute([$comment['review_id']]);
        $review = $rstmt->fetch(PDO::FETCH_ASSOC);

        require '../app/views/comments/edit.php';
    }

    // ── UPDATE ───────────────────────────────────────────────
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
            header("Location: ?url=review/index"); exit();
        }
        $this->comment->id = $_POST['id'];
        $comment = $this->comment->readOne();

        if ($comment['user_id'] != $_SESSION['user_id'] && !$this->isAdmin()) {
            die("Nepovolená akce!");
        }
        $this->comment->comment_text = $_POST['comment_text'];
        if ($this->comment->update()) {
            header("Location: ?url=review/show&id=" . $comment['review_id']);
        }
        exit();
    }

    // ── DELETE ───────────────────────────────────────────────
    public function delete() {
        if (!isset($_SESSION['user_id'], $_GET['id'])) {
            header("Location: ?url=review/index"); exit();
        }
        $this->comment->id = $_GET['id'];
        $comment = $this->comment->readOne();

        if ($comment['user_id'] == $_SESSION['user_id'] || $this->isAdmin()) {
            $this->comment->delete();
            header("Location: ?url=review/show&id=" . $comment['review_id']);
        } else {
            die("Nepovolená akce!");
        }
        exit();
    }
}
?>
