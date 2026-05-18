<?php
class Comment {
    private $conn;
    private $table_name = "comments";

    public $id;
    public $review_id;
    public $user_id;
    public $comment_text;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table_name} SET review_id=:review_id, user_id=:user_id, comment_text=:comment_text"
        );
        $stmt->bindParam(':review_id',    $this->review_id);
        $stmt->bindParam(':user_id',      $this->user_id);
        $stmt->bindParam(':comment_text', htmlspecialchars(strip_tags($this->comment_text)));
        return $stmt->execute();
    }

    public function getCommentsByReview($review_id) {
        $stmt = $this->conn->prepare(
            "SELECT c.*, u.username FROM {$this->table_name} c
             JOIN users u ON c.user_id = u.id
             WHERE c.review_id = :review_id ORDER BY c.created_at DESC"
        );
        $stmt->bindParam(':review_id', $review_id);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table_name} WHERE id = ? LIMIT 1");
        $stmt->execute([$this->id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // NOVÉ: úprava textu komentáře
    public function update() {
        $stmt = $this->conn->prepare(
            "UPDATE {$this->table_name} SET comment_text = :comment_text WHERE id = :id"
        );
        $stmt->bindParam(':comment_text', htmlspecialchars(strip_tags($this->comment_text)));
        $stmt->bindParam(':id',           $this->id);
        return $stmt->execute();
    }

    public function delete() {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table_name} WHERE id = :id");
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }
}
?>
