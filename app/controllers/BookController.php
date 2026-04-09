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
            $bookModel = new Book($db);

            // Zpracování obrázků pomocí naší nové metody!
            $uploadedImages = $this->processImageUploads(); 

            // Přidáme nahrané obrázky do pole $_POST, aby se uložily do databáze
            // (Musíme je převést na text pomocí json_encode)
            $_POST['images'] = json_encode($uploadedImages);

            if ($bookModel->create($_POST)) {
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

            $database = new Database();
            $db = $database->getConnection();
            $bookModel = new Book($db);

// --- ŘEŠENÍ KROKU 5: ZACHOVÁNÍ OBRÁZKŮ ---
            // 1. Získáme aktuální knihu z DB, abychom věděli, jaké má staré obrázky
            $currentBook = $bookModel->getById($id);
            
            // 2. Pokusíme se nahrát NOVÉ obrázky
            $newImages = $this->processImageUploads(); 

            // 3. Pokud uživatel nahrál nové, použijeme je. Pokud ne, zachováme staré.
            if (!empty($newImages)) {
                $uploadedImages = $newImages;
            } else {
                // Musíme text z databáze překlopit zpátky na pole
                $uploadedImages = !empty($currentBook['images']) ? json_decode($currentBook['images'], true) : [];
            }
            // ------------------------------------------

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
        if (!$id) {
            header('Location: /WA-2026-SARA-KRISTANOVA/public/index.php');
            exit;
        }

        $database = new Database();
        $db = $database->getConnection();
        
        $bookModel = new Book($db);
        $book = $bookModel->getById($id);

        if (!$book) {
            header('Location: /WA-2026-SARA-KRISTANOVA/public/index.php');
            exit;
        }

        require_once '../app/views/books/book_show.php';
    }

    // --- Pomocná metoda pro zpracování nahrávání obrázků ---
    protected function processImageUploads() {
        $uploadedFiles = []; 
        $uploadDir = __DIR__ . '/../../public/uploads/'; 
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $fileCount = count($_FILES['images']['name']);

            for ($i = 0; $i < $fileCount; $i++) {
                if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                    $tmpName = $_FILES['images']['tmp_name'][$i];
                    $originalName = basename($_FILES['images']['name'][$i]);

                    // --- NOVÁ BEZPEČNOSTNÍ KONTROLA (MIME TYPE) ---
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $realMimeType = finfo_file($finfo, $tmpName);
                    finfo_close($finfo);

                    // Povolené skutečné typy souborů
                    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];

                    // Je to opravdu obrázek uvnitř?
                    if (!in_array($realMimeType, $allowedMimeTypes)) {
                        continue; // Přeskočíme tento podvržený soubor
                    }
                    // ----------------------------------------------

                    // Pro jistotu zkontrolujeme ještě i tu starou koncovku názvu
                    $fileExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                    
                    if (!in_array($fileExtension, $allowedExtensions)) {
                        continue; 
                    }

                    $newName = 'book_' . uniqid() . '_' . substr(md5(mt_rand()), 0, 4) . '.' . $fileExtension;
                    $targetFilePath = $uploadDir . $newName;

                    if (move_uploaded_file($tmpName, $targetFilePath)) {
                        $uploadedFiles[] = $newName; 
                    }
                }
            }
        }
        return $uploadedFiles;
    }
}
?>