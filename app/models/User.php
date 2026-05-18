<?php
class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $username;
    public $password;
    public $role;

    public function __construct($db) {
        $this->conn = $db;
    }

    // --- REGISTRACE ---
    public function register() {
        $check = $this->conn->prepare("SELECT id FROM {$this->table_name} WHERE username = :u LIMIT 1");
        $check->bindParam(':u', $this->username);
        $check->execute();
        if ($check->rowCount() > 0) return false;

        $stmt = $this->conn->prepare("INSERT INTO {$this->table_name} SET username=:username, password=:password");
        $this->username = htmlspecialchars(strip_tags($this->username));
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        return $stmt->execute();
    }

    // --- PŘIHLÁŠENÍ ---
    public function login() {
        $stmt = $this->conn->prepare("SELECT id, username, password, role FROM {$this->table_name} WHERE username = :u LIMIT 1");
        $this->username = htmlspecialchars(strip_tags($this->username));
        $stmt->bindParam(':u', $this->username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($this->password, $row['password'])) {
                $this->id   = $row['id'];
                $this->role = $row['role'];
                return true;
            }
        }
        return false;
    }

    // --- NAJDI UŽIVATELE PODLE ID ---
    public function findById($id) {
        $stmt = $this->conn->prepare("SELECT id, username, role FROM {$this->table_name} WHERE id = :id LIMIT 1");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // --- ZMĚNA HESLA ---
    public function updatePassword($id, $newHashedPassword) {
        $stmt = $this->conn->prepare("UPDATE {$this->table_name} SET password = :p WHERE id = :id");
        $stmt->bindParam(':p',  $newHashedPassword);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // --- SMAZÁNÍ UŽIVATELE (pouze admin) ---
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table_name} WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // --- SEZNAM VŠECH UŽIVATELŮ (pro admin panel) ---
    public function getAll() {
        $stmt = $this->conn->prepare(
            "SELECT id, username, role,
                    (SELECT COUNT(*) FROM reviews WHERE user_id = users.id) AS review_count
             FROM {$this->table_name}
             ORDER BY id ASC"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
