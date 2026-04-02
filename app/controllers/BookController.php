<?php
// Nezapomeň includovat modely, které budeš potřebovat
require_once '../app/models/Database.php';
require_once '../app/models/Book.php';

class BookController {

    // 1. Úvodní stránka (výpis všech knih)
    public function index() {
        $database = new Database();
        $db = $database->getConnection();
        
        $book = new Book($db);
        $books = $book->getAll();
        
        require_once '../app/views/books/books_list.php';
    }

    // 2. Metoda pro zobrazení formuláře pro přidání knihy
    public function create() {
        require_once '../app/views/books/book_create.php';
    }

    // 3. Metoda pro uložení NOVÉ knihy do databáze
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $database = new Database();
            $db = $database->getConnection();
            
            $book = new Book($db);

            if ($book->create($_POST)) {
                header("Location: /WA-2026-SARA-KRISTANOVA/public/index.php");
                exit();
            } else {
                echo "Jejda! Knihu se nepodařilo uložit.";
            }
        }
    }

    // 4. Smazání existující knihy
    public function delete($id = null) {
        if (!$id) {
            header('Location: /WA-2026-SARA-KRISTANOVA/public/index.php');
            exit;
        }

        $database = new Database();
        $db = $database->getConnection();
        
        $bookModel = new Book($db);
        $bookModel->delete($id);

        header('Location: /WA-2026-SARA-KRISTANOVA/public/index.php');
        exit;
    }

    // 5. Zobrazení formuláře pro úpravu existující knihy
    public function edit($id = null) {
        if (!$id) {
            header('Location: /WA-2026-SARA-KRISTANOVA/public/index.php');
            exit;
        }

        $database = new Database();
        $db = $database->getConnection();
        
        $bookModel = new Book($db);
        $book = $bookModel->getById($id);

        // Pokud kniha neexistuje (např. někdo zadal špatné ID do URL)
        if (!$book) {
            header('Location: /WA-2026-SARA-KRISTANOVA/public/index.php');
            exit;
        }

        require_once '../app/views/books/book_edit.php';
    }

    // 6. Zpracování a uložení UPRAVENÝCH dat do databáze
    public function update($id = null) {
        if (!$id) {
            header('Location: /WA-2026-SARA-KRISTANOVA/public/index.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $title = htmlspecialchars($_POST['title'] ?? '');
            $author = htmlspecialchars($_POST['author'] ?? '');
            $isbn = htmlspecialchars($_POST['isbn'] ?? '');
            $category = htmlspecialchars($_POST['category'] ?? '');
            $subcategory = htmlspecialchars($_POST['subcategory'] ?? '');
            $year = (int)($_POST['year'] ?? 0);
            $price = (float)($_POST['price'] ?? 0);
            $link = htmlspecialchars($_POST['link'] ?? '');
            $description = htmlspecialchars($_POST['description'] ?? '');

            $uploadedImages = []; 

            $database = new Database();
            $db = $database->getConnection();

            $bookModel = new Book($db);
            $bookModel->update(
                $id, $title, $author, $category, $subcategory, 
                $year, $price, $isbn, $description, $link, $uploadedImages
            );

            // Po úspěšném updatu se vrátíme na seznam
            header('Location: /WA-2026-SARA-KRISTANOVA/public/index.php');
            exit;
            
        } else {
            // Pokud sem někdo skočí přímo přes URL bez POSTu, vykopneme ho na domovskou stránku
            header('Location: /WA-2026-SARA-KRISTANOVA/public/index.php');
            exit;
        }
    }
    // 7. Zobrazení detailu konkrétní knihy
    public function show($id = null) {
        // Kontrola, zda existuje ID
        if (!$id) {
            header('Location: /WA-2026-SARA-KRISTANOVA/public/index.php');
            exit;
        }

        // Spojení s databází
        $database = new Database();
        $db = $database->getConnection();
        
        // Získání dat z modelu
        $bookModel = new Book($db);
        $book = $bookModel->getById($id);

        // Kontrola, zda databáze knihu našla
        if (!$book) {
            header('Location: /WA-2026-SARA-KRISTANOVA/public/index.php');
            exit;
        }

        // Načtení nového pohledu
        require_once '../app/views/books/book_show.php';
    }
}
?>