<?php
// Načteme potřebné soubory (stejně jako u Profilu)
require_once '../app/models/Database.php';
require_once '../app/models/Review.php';

class CatalogController {
    private $db;
    private $review;

  public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->review = new Review($this->db);
        
        // Nastartujeme session, abychom věděli, kdo je přihlášený
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    // --- ZOBRAZENÍ KATALOGU AUT A FILTRACE ---
public function index() {
        $search_term = isset($_GET['search']) ? $_GET['search'] : "";
        $fuel_type = isset($_GET['fuel']) ? $_GET['fuel'] : "";
        
        // Odchytíme filtr doporučení (bude to buď "", "1", nebo "0")
        $recommend_status = isset($_GET['recommend']) ? $_GET['recommend'] : "";

        // Nezapomeň použít ty cesty k databázi, které ti už fungují!
        $stmt = $this->review->search($search_term, $fuel_type, $recommend_status);
        $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require '../app/views/catalog/index.php';
    }
}
?>