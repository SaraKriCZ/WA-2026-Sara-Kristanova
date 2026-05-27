<?php
require_once '../app/models/Database.php';
require_once '../app/models/Review.php';
require_once '../app/models/Reaction.php';
require_once '../app/models/Comment.php';

class ReviewController {
    private $db;
    private $review;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) session_start();
        $database     = new Database();
        $this->db     = $database->getConnection();
        $this->review = new Review($this->db);
    }

    public function index() {
        $stmt        = $this->review->getLatestReviews();
        $top_reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require '../app/views/reviews/index.php';
    }

    public function create() {
        if (!isset($_SESSION['user_id'])) { header("Location: ?url=user/login"); exit(); }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->review->user_id            = $_SESSION['user_id'];
            $this->review->brand              = $_POST['brand'];
            $this->review->model              = $_POST['model'];
            $this->review->year               = $_POST['year'];
            $this->review->fuel               = $_POST['fuel'];
            $this->review->engine_volume      = $_POST['engine_volume'];
            $this->review->power              = $_POST['power'];
            $this->review->rating_comfort     = $_POST['rating_comfort'];
            $this->review->rating_performance = $_POST['rating_performance'];
            $this->review->rating_design      = $_POST['rating_design'];
            $this->review->review_text        = $_POST['review_text'];
            $this->review->recommend          = isset($_POST['recommend']) ? 1 : 0;
            $this->review->image_path         = null;

            // Zkontroluje jestli soubor přišel bez chyby
            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                $dir = "uploads/";
                if (!is_dir($dir)) mkdir($dir, 0777, true);
                $ext  = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $path = $dir . uniqid() . '.' . $ext; // Vygeneruje náhodné jméno souboru – útočník nemůže ovlivnit název
                if (move_uploaded_file($_FILES['image']['tmp_name'], $path)) { // Bezpečně přesune soubor z dočasného umístění
                    $this->review->image_path = $path;
                }
            }

            if ($this->review->create()) { header("Location: ?url=profile/index"); exit(); }
            $error_message = "Chyba při ukládání recenze.";
        }
        require '../app/views/reviews/create.php';
    }

    public function show() {
        if (!isset($_GET['id'])) { header("Location: ?url=review/index"); exit(); }

        $this->review->id = $_GET['id'];
        $car = $this->review->readOne();
        if (!$car) { header("Location: ?url=review/index"); exit(); }

        $reactionModel = new Reaction($this->db);
        $counts        = $reactionModel->getCounts($car['id']);
        $my_reaction   = null;

        if (isset($_SESSION['user_id'])) {
            $stmt = $this->db->prepare("SELECT reaction_type FROM reactions WHERE user_id=? AND review_id=?");
            $stmt->execute([$_SESSION['user_id'], $car['id']]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($res) $my_reaction = $res['reaction_type'];
        }

        $commentModel = new Comment($this->db);
        $comments     = $commentModel->getCommentsByReview($car['id'])->fetchAll(PDO::FETCH_ASSOC);

        require '../app/views/reviews/show.php';
    }

    public function edit() {
        if (!isset($_GET['id'])) { header("Location: ?url=review/index"); exit(); }
        $this->review->id = $_GET['id'];
        $car = $this->review->readOne();
        if ($car['user_id'] != $_SESSION['user_id']) die("Nemáte oprávnění.");
        require '../app/views/reviews/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: ?url=review/index"); exit(); }

        $this->review->id = $_POST['id'];
        $car = $this->review->readOne();
        if ($car['user_id'] != $_SESSION['user_id']) die("Nepovolená akce!");

        $this->review->brand              = $_POST['brand'];
        $this->review->model              = $_POST['model'];
        $this->review->year               = $_POST['year'];
        $this->review->fuel               = $_POST['fuel'];
        $this->review->engine_volume      = $_POST['engine_volume'];
        $this->review->power              = $_POST['power'];
        $this->review->rating_comfort     = $_POST['rating_comfort'];
        $this->review->rating_performance = $_POST['rating_performance'];
        $this->review->rating_design      = $_POST['rating_design'];
        $this->review->review_text        = $_POST['review_text'];
        $this->review->recommend          = isset($_POST['recommend']) ? 1 : 0;
        $this->review->updated_by         = $_SESSION['user_id'];

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // TADY se maže stará fotka ze serveru
            if (!empty($car['image_path']) && file_exists($car['image_path'])) unlink($car['image_path']); // ← tohle smaže soubor
            $dir  = "uploads/";
            if (!is_dir($dir)) mkdir($dir, 0777, true);
            // A nahraje se nová
            $ext  = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $path = $dir . uniqid() . '.' . $ext;
            $this->review->image_path = move_uploaded_file($_FILES['image']['tmp_name'], $path) ? $path : $car['image_path'];
        } else {
            $this->review->image_path = $car['image_path'];
        }

        if ($this->review->update()) { header("Location: ?url=review/show&id=" . $this->review->id); exit(); }
    }

    // Smazání – owner NEBO admin
    public function delete() {
        if (!isset($_GET['id'])) { header("Location: ?url=review/index"); exit(); }

        $this->review->id = $_GET['id'];
        $car = $this->review->readOne();

        $isOwner = isset($_SESSION['user_id']) && $car['user_id'] == $_SESSION['user_id'];
        $isAdmin = isset($_SESSION['role'])    && $_SESSION['role'] === 'admin';

        if ($isOwner || $isAdmin) {
            if (!empty($car['image_path']) && file_exists($car['image_path'])) unlink($car['image_path']);
            $this->review->delete();
        }

        // Admin se vrátí do admin panelu, owner na homepage
        if ($isAdmin && !$isOwner) {
            header("Location: ?url=profile/adminReviews&deleted=1");
        } else {
            header("Location: ?url=review/index");
        }
        exit();
    }
}
?>
