<?php
// Nezapomeň si tyto cesty upravit tak, jak ti fungují v ostatních kontrolerech!
require_once '../app/models/Database.php';
require_once '../app/models/Review.php';
require_once '../app/models/Reaction.php';

class ReactionController {
    
    public function toggle() {
        if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
        // Javascript k nám bude posílat data speciálním způsobem (JSON), musíme je takto rozkódovat
        $data = json_decode(file_get_contents('php://input'), true);
        
        // Ochrana: Je uživatel přihlášený?
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['status' => 'error', 'message' => 'not_logged_in']);
            return;
        }

        $user_id = $_SESSION['user_id'];
        $review_id = $data['review_id'];
        $reaction_type = $data['reaction_type']; // 'agree', 'disagree', nebo 'interesting'

        // Připojení k DB a modelu
        $database = new Database();
        $db = $database->getConnection();
        $reaction = new Reaction($db);

        // Provedeme změnu v databázi
        $reaction->toggleReaction($user_id, $review_id, $reaction_type);
        
        // Získáme nové součty, abychom je mohli vrátit do prohlížeče a aktualizovat čísílka
        $new_counts = $reaction->getCounts($review_id);

        // Odpovíme Javascriptu v pořádku
        echo json_encode([
            'status' => 'success',
            'counts' => $new_counts
        ]);
    }
}
?>