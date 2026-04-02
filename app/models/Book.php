<?php
class Book {
    private $conn;
    private $table_name = "books"; // Zde doplň reálný název tvé tabulky v databázi, pokud se jmenuje jinak

    // Konstruktor - při vytvoření objektu Book mu předáme připojení k DB
    public function __construct($db) {
        $this->conn = $db;
    }

    // Metoda pro vytvoření nové knihy
    public function create($data) {
        // Příprava SQL dotazu (používáme zástupné znaky :nazev pro bezpečnost)
        $query = "INSERT INTO " . $this->table_name . " 
                  (title, author, isbn, category, subcategory, year, price, link, description) 
                  VALUES 
                  (:title, :author, :isbn, :category, :subcategory, :year, :price, :link, :desc)";

        $stmt = $this->conn->prepare($query);

        // Očištění dat (odstranění zbytečných mezer a HTML tagů)
        $title = htmlspecialchars(strip_tags($data['title']));
        $author = htmlspecialchars(strip_tags($data['author']));
        $isbn = htmlspecialchars(strip_tags($data['isbn']));
        $category = htmlspecialchars(strip_tags($data['category']));
        $subcategory = htmlspecialchars(strip_tags($data['subcategory']));
        $year = htmlspecialchars(strip_tags($data['year']));
        $price = htmlspecialchars(strip_tags($data['price']));
        $link = htmlspecialchars(strip_tags($data['link']));
        $desc = htmlspecialchars(strip_tags($data['desc']));

        // Propojení proměnných se zástupnými znaky v SQL dotazu
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":author", $author);
        $stmt->bindParam(":isbn", $isbn);
        $stmt->bindParam(":category", $category);
        $stmt->bindParam(":subcategory", $subcategory);
        $stmt->bindParam(":year", $year);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":link", $link);
        $stmt->bindParam(":desc", $desc);

        // Spuštění dotazu
        if($stmt->execute()) {
            return true; // Uložení se povedlo
        }
        
        return false; // Uložení se nepovedlo
    }
    // Metoda pro načtení všech knih
    public function getAll() {
        // Jednoduchý SQL dotaz, který vybere vše z tabulky books a seřadí je od nejnovější
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        // PDO::FETCH_ASSOC nám vrátí data jako hezké asociativní pole (klíč => hodnota)
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
        // Získání jedné konkrétní knihy podle jejího ID
    public function getById($id) {
        $sql = "SELECT * FROM books WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        // Používá se fetch() místo fetchAll(), protože očekáváme maximálně jeden výsledek.
        // Vrátí asociativní pole s daty knihy, nebo false, pokud kniha neexistuje.
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Aktualizace existující knihy
    public function update(
        $id, $title, $author, $category, $subcategory, 
        $year, $price, $isbn, $description, $link, $images = []
    ) {
        $sql = "UPDATE books 
                SET title = :title, 
                    author = :author, 
                    category = :category, 
                    subcategory = :subcategory, 
                    year = :year, 
                    price = :price, 
                    isbn = :isbn, 
                    description = :description, 
                    link = :link, 
                    images = :images
                WHERE id = :id";
                
        $stmt = $this->conn->prepare($sql);

        // Parametrů je stejné množství jako u create, navíc je pouze :id
        return $stmt->execute([
            ':id' => $id,
            ':title' => $title,
            ':author' => $author,
            ':category' => $category,
            ':subcategory' => $subcategory ?: null,
            ':year' => $year,
            ':price' => $price,
            ':isbn' => $isbn,
            ':description' => $description,
            ':link' => $link,
            ':images' => json_encode($images)
        ]);
    }
    // Trvalé smazání knihy z databáze
    public function delete($id) {
        $sql = "DELETE FROM books WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        
        // Vrací true při úspěchu, false při chybě
        return $stmt->execute([':id' => $id]);
    }
}
?>