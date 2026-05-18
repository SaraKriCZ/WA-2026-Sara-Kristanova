<?php

class Review {
    private $conn;
    private $table_name = "reviews";

    // Všechny vlastnosti auta (přesně odpovídají novým sloupcům v databázi)
    public $id;
    public $user_id;
    public $brand;
    public $model;
    public $year;
    public $fuel;
    public $engine_volume;
    public $power;
    public $image_path;
    public $updated_by;
public $updated_at;
    
    // 🌟 Naše nové hvězdičkové kategorie
    public $rating_comfort;     
    public $rating_performance; 
    public $rating_design;      
    
    public $review_text;
    public $recommend;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // --- METODA PRO PŘIDÁNÍ NOVÉ RECENZE (AUTA) ---
    public function create() {
        // Nový SQL dotaz, který ukládá hvězdičky místo plusů a minusů
        $query = "INSERT INTO " . $this->table_name . " 
                  SET user_id=:user_id, brand=:brand, model=:model, year=:year, 
                      fuel=:fuel, engine_volume=:engine_volume, power=:power, 
                      image_path=:image_path, 
                      rating_comfort=:rating_comfort, rating_performance=:rating_performance, rating_design=:rating_design, 
                      review_text=:review_text, recommend=:recommend";

        $stmt = $this->conn->prepare($query);

        // Očištění textových vstupů od nebezpečných znaků
        $this->brand = htmlspecialchars(strip_tags($this->brand));
        $this->model = htmlspecialchars(strip_tags($this->model));
        $this->fuel = htmlspecialchars(strip_tags($this->fuel));
        $this->review_text = htmlspecialchars(strip_tags($this->review_text));
        
        // Cestu k obrázku vyčistíme, pokud existuje
        if($this->image_path) {
            $this->image_path = htmlspecialchars(strip_tags($this->image_path));
        }

        // Propojení dat z formuláře s databází
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":brand", $this->brand);
        $stmt->bindParam(":model", $this->model);
        $stmt->bindParam(":year", $this->year);
        $stmt->bindParam(":fuel", $this->fuel);
        $stmt->bindParam(":engine_volume", $this->engine_volume);
        $stmt->bindParam(":power", $this->power);
        $stmt->bindParam(":image_path", $this->image_path);
        
        // Propojení našich 3 nových hvězdiček
        $stmt->bindParam(":rating_comfort", $this->rating_comfort);
        $stmt->bindParam(":rating_performance", $this->rating_performance);
        $stmt->bindParam(":rating_design", $this->rating_design);
        
        $stmt->bindParam(":review_text", $this->review_text);
        $stmt->bindParam(":recommend", $this->recommend);

        // Spuštění dotazu - pokud se auto uloží, vrátíme true
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // --- METODA PRO VÝPIS VŠECH AUT (NA HLAVNÍ STRÁNKU) ---
    public function readAll() {
        // Vezmeme všechna auta a připojíme k nim jméno autora z tabulky 'users'
        $query = "SELECT r.*, u.username 
                  FROM " . $this->table_name . " r
                  LEFT JOIN users u ON r.user_id = u.id
                  ORDER BY r.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
    // --- METODA PRO DETAIL JEDNOHO AUTA ---
    public function readOne() {
        // Vybereme auto podle ID a rovnou k němu připojíme i jméno autora
        $query = "SELECT r.*, u.username 
                  FROM " . $this->table_name . " r
                  LEFT JOIN users u ON r.user_id = u.id
                  WHERE r.id = ? 
                  LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id); // Místo otazníku dosadíme ID auta
        $stmt->execute();

        // Vrátíme data jako asociativní pole
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // --- METODA PRO ÚPRAVU RECENZE ---
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET brand=:brand, model=:model, year=:year, fuel=:fuel, 
                      engine_volume=:engine_volume,updated_by = :updated_by, updated_at = NOW(), power=:power, 
                      rating_comfort=:rating_comfort, rating_performance=:rating_performance, 
                      rating_design=:rating_design, review_text=:review_text, 
                      recommend=:recommend 
                  WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        // Bindování parametrů (stejné jako u create, ale přidáváme :id)
        $stmt->bindParam(":brand", $this->brand);
        $stmt->bindParam(":model", $this->model);
        $stmt->bindParam(":year", $this->year);
        $stmt->bindParam(":fuel", $this->fuel);
        $stmt->bindParam(":engine_volume", $this->engine_volume);
        $stmt->bindParam(":power", $this->power);
        $stmt->bindParam(':updated_by', $this->updated_by); // PŘIDÁNO
        $stmt->bindParam(":rating_comfort", $this->rating_comfort);
        $stmt->bindParam(":rating_performance", $this->rating_performance);
        $stmt->bindParam(":rating_design", $this->rating_design);
        $stmt->bindParam(":review_text", $this->review_text);
        $stmt->bindParam(":recommend", $this->recommend);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    // --- METODA PRO SMAZÁNÍ RECENZE ---
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        return $stmt->execute();
    }
    // --- METODA PRO VÝPIS AUT KONKRÉTNÍHO UŽIVATELE (PROFIL) ---
    public function readByUser($user_id) {
        $query = "SELECT r.*, u.username 
                  FROM " . $this->table_name . " r
                  LEFT JOIN users u ON r.user_id = u.id
                  WHERE r.user_id = ?
                  ORDER BY r.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $user_id);
        $stmt->execute();

        return $stmt;
    }
    // --- METODA PRO VYHLEDÁVÁNÍ A FILTROVÁNÍ (KATALOG) ---
    public function search($search_term = "", $fuel_type = "", $recommend_status = "") {
        $query = "SELECT r.*, u.username 
                  FROM " . $this->table_name . " r
                  LEFT JOIN users u ON r.user_id = u.id
                  WHERE 1=1"; 
        
        $params = [];

        if (!empty($search_term)) {
            $query .= " AND (r.brand LIKE ? OR r.model LIKE ?)";
            $search_wildcard = "%" . $search_term . "%"; 
            $params[] = $search_wildcard;
            $params[] = $search_wildcard;
        }

        if (!empty($fuel_type)) {
            $query .= " AND r.fuel = ?";
            $params[] = $fuel_type;
        }

        // --- NOVÁ ČÁST: Filtr doporučení ---
        if ($recommend_status !== "") {
            $query .= " AND r.recommend = ?";
            $params[] = $recommend_status; // 1 pro doporučuji, 0 pro nedoporučuji
        }

        $query .= " ORDER BY r.created_at DESC";
        $stmt = $this->conn->prepare($query);

        foreach ($params as $key => $val) {
            $stmt->bindValue($key + 1, $val);
        }

        $stmt->execute();
        return $stmt;
    }
    // --- METODA PRO ZÍSKÁNÍ 3 NEJNOVĚJŠÍCH AUT PRO HLAVNÍ STRÁNKU ---
    public function getLatestReviews() {
        $query = "SELECT r.*, u.username 
                  FROM " . $this->table_name . " r
                  LEFT JOIN users u ON r.user_id = u.id
                  ORDER BY r.created_at DESC
                  LIMIT 3"; // LIMIT 3 nám zajistí, že se jich nenačte víc
                  
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
}
?>