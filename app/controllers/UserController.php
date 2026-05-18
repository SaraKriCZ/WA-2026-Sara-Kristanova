<?php
// Připojíme si soubory, které budeme potřebovat
require_once '../app/models/Database.php';
require_once '../app/models/User.php';

class UserController {
    private $db;
    private $user;

    // Konstruktor se spustí automaticky vždy, když kontroler zavoláme
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    // --- METODA PRO ZOBRAZENÍ A ZPRACOVÁNÍ REGISTRACE ---
public function register() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $this->user->username = $_POST['username'];
        $password = $_POST['password'];

        // --- 1. KONTROLA HESLA ---
        $errors = [];
        if (strlen($password) < 8) {
            $errors[] = "Heslo musí mít alespoň 8 znaků.";
        }
        if (!preg_match("/[0-9]/", $password)) {
            $errors[] = "Heslo musí obsahovat alespoň jednu číslici.";
        }
        if (!preg_match("/[A-Z]/", $password)) {
            $errors[] = "Heslo musí obsahovat alespoň jedno velké písmeno.";
        }

        // --- 2. VYHODNOCENÍ ---
        if (empty($errors)) {
            // Heslo prošlo kontrolou -> zahashujeme ho
            $this->user->password = password_hash($password, PASSWORD_BCRYPT);

            // Zkusíme uložit do databáze
            if ($this->user->register()) {
                header("Location: ?url=user/login&success=1");
                exit();
            } else {
                $error_message = "Uživatelské jméno již existuje.";
                require '../app/views/users/register.php';
                return; // Důležité, abychom nepokračovali dál
            }
        } else {
            // Heslo nesplňuje podmínky -> zobrazíme chyby
            $error_message = implode("<br>", $errors);
            require '../app/views/users/register.php';
            return; // Důležité, abychom nepokračovali dál
        }
    }
    
    // Pokud uživatel jen přišel na stránku (GET), zobrazíme formulář
    require '../app/views/users/register.php';
}

    // --- METODA PRO ZOBRAZENÍ A ZPRACOVÁNÍ PŘIHLÁŠENÍ ---
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->user->username = $_POST['username'];
            $this->user->password = $_POST['password'];

            if ($this->user->login()) {
                // MAGIE PŘIHLÁŠENÍ: Sessions (Relace)
                // Uložíme si "štítek", že je uživatel přihlášený, dokud nezavře prohlížeč
                session_start();
                $_SESSION['user_id'] = $this->user->id;
                $_SESSION['username'] = $this->user->username;
                $_SESSION['role'] = $this->user->role;

                // Přesměrujeme ho na hlavní stránku (naši budoucí knihovnu aut)
                header("Location: index.php");
                exit();
            } else {
                $error_message = "Špatné uživatelské jméno nebo heslo.";
                require '../app/views/users/login.php';
                return;
            }
        }
        require '../app/views/users/login.php';
    }

    public function logout() {
    // Pro jistotu nastartujeme session, abychom měli co mazat
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Vymažeme všechny proměnné v session (např. user_id, username)
    $_SESSION = array();

    // Zničíme celou session
    session_destroy();

    // Přesměrujeme uživatele zpět na přihlašovací stránku (nebo na úvodní stránku katalogu)
    header("Location: ?url=catalog/index");
    exit();
}
}
?>