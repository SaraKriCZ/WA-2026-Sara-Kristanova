<?php
class Reaction {
    private $conn;
    // Zde doplň přesný název tvé tabulky z databáze (podle screenu tipuji review_reactions)
    private $table_name = "reactions"; 

    public function __construct($db) {
        $this->conn = $db;
    }

    // --- METODA PRO PŘIDÁNÍ / ZMĚNU / ODEBRÁNÍ REAKCE ---
    public function toggleReaction($user_id, $review_id, $reaction_type) {
        // 1. Zjistíme, jestli uživatel už na tuto recenzi reagoval
        $query = "SELECT reaction_type FROM " . $this->table_name . " WHERE user_id = ? AND review_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id, $review_id]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            if ($existing['reaction_type'] === $reaction_type) {
                // Kliknul na to samé = chce reakci smazat (odkliknout)
                $delQuery = "DELETE FROM " . $this->table_name . " WHERE user_id = ? AND review_id = ?";
                $delStmt = $this->conn->prepare($delQuery);
                $delStmt->execute([$user_id, $review_id]);
                return 'removed';
            } else {
                // Kliknul na něco jiného = chce reakci přepsat
                $updQuery = "UPDATE " . $this->table_name . " SET reaction_type = ? WHERE user_id = ? AND review_id = ?";
                $updStmt = $this->conn->prepare($updQuery);
                $updStmt->execute([$reaction_type, $user_id, $review_id]);
                return 'updated';
            }
        } else {
            // Ještě nereagoval = přidáme novou
            $insQuery = "INSERT INTO " . $this->table_name . " (user_id, review_id, reaction_type) VALUES (?, ?, ?)";
            $insStmt = $this->conn->prepare($insQuery);
            $insStmt->execute([$user_id, $review_id, $reaction_type]);
            return 'added';
        }
    }

    // --- METODA PRO ZÍSKÁNÍ AKTUÁLNÍCH SOUČTŮ ---
    public function getCounts($review_id) {
        $query = "SELECT reaction_type, COUNT(*) as count FROM " . $this->table_name . " WHERE review_id = ? GROUP BY reaction_type";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$review_id]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Výchozí stav (všechno je 0)
        $counts = ['agree' => 0, 'disagree' => 0, 'interesting' => 0];
        
        // Doplníme tam skutečná čísla z databáze
        foreach ($results as $row) {
            $counts[$row['reaction_type']] = $row['count'];
        }
        return $counts;
    }
}
?>